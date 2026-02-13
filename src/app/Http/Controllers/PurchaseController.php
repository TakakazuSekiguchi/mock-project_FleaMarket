<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    public function show(Request $request, Item $item){
        $user = auth()->user();
        $item = Item::findOrFail($item->id);
        $address = Address::where('user_id', "{$user->id}")->first();

        $hasAddressError = empty($address?->postal_code) || empty($address?->address);

        Stripe::setApiKey(config('services.stripe.secret'));
        $intent = PaymentIntent::create([
            'amount' => $item->price, 
            'currency' => 'jpy',
        ]);

        return view('purchase', [
            'item' => $item,
            'user' => $user,
            'address' => $address,
            'hasAddressError' => $hasAddressError,
            'clientSecret' => $intent->client_secret,
        ]);
    }

    public function checkout(PurchaseRequest $request, Item $item){
        $buyer = auth()->user();
        $address = Address::where('user_id', "{$buyer->id}")->first();

        if (!$address) {
            abort(400, '配送先住所が登録されていません');
        }
        
        if ($item->status === 1) {
            abort(403, 'この商品はすでに購入されています');
        }

        if ($item->user_id === $buyer->id) {
            abort(403, '出品者は自分の商品を購入できません');
        }

        // 支払い方法
        $paymentMethod = $request->payment_method;

        if ($paymentMethod == 1) {
            // カード払い
            $paymentTypes = ['card'];
        } else {
            // コンビニ払い
            $paymentTypes = ['konbini'];
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'payment_method_types' => $paymentTypes,

            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],

            'mode' => 'payment',

            'success_url' => route('mypage.buy'),
            'cancel_url' => route('purchase.cancel'),

            // Webhook用
            'payment_intent_data' => [
                'metadata' => [
                    'item_id' => $item->id,
                    'buyer_id' => $buyer->id,
                    'payment_method' => $paymentMethod,
                    'postal_code' => $address->postal_code,
                    'address' => $address->address,
                    'building' => $address->building,
                ],
            ],
        ]);

        return redirect($session->url);
    }

    public function webhook(Request $request){
        //Stripe側でwebhookが受け取られているか、laravel.logで確認
        \Log::info('Stripe webhook received');

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Exception $e) {
            \Log::error('Stripe webhook verification failed', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['status' => 'invalid'], 400);
        }

        // payment_intent.succeeded だけ処理
        if ($event->type !== 'payment_intent.succeeded') {
            return response()->json(['status' => 'ignored']);
        }

        $intent = $event->data->object;

        $itemId  = $intent->metadata->item_id ?? null;
        $buyerId = $intent->metadata->buyer_id ?? null;

        if (!$itemId || !$buyerId) {
            \Log::error('metadata missing');
            return response()->json(['status' => 'error']);
        }

        $item = Item::find($itemId);

        //Stripe側にmetadataが送られているか、laravel.logで確認
        \Log::info('PaymentIntent metadata', (array) $intent->metadata);

        if (!$item || $item->status === 1) {
            return response()->json(['status' => 'already processed']);
        }

        \DB::transaction(function () use ($item, $buyerId, $intent) {
            Purchase::create([
                'item_id' => $item->id,
                'buyer_id' => $buyerId,
                'seller_id' => $item->user_id,
                'payment_method' => $intent->metadata->payment_method,
                'postal_code' => $intent->metadata->postal_code,
                'address' => $intent->metadata->address,
                'building' => $intent->metadata->building,
            ]);

            $item->update([
                'buyer_id' => $buyerId,
                'status' => 1,
            ]);
        });

        return response()->json(['status' => 'ok']);
    }
}
