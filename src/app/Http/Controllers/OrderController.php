<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Order;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function show(Request $request, Item $item){
        $user = Auth::user();
        $item = Item::findOrFail($item->id);
        $address = Address::where('user_id', "{$user->id}")->first();

        $hasAddressError = empty($address?->postal_code) || empty($address?->address);

        return view('order', compact('item', 'user', 'address', 'hasAddressError'));
    }

    public function store(PurchaseRequest $request, Item $item){
        $buyer = Auth::user();

        if ($item->status === 1) {
            abort(403, 'この商品はすでに購入されています');
        }

        if ($item->user_id === $buyer->id) {
            abort(403, '出品者は自分の商品を購入できません');
        }

        Order::create([
            'item_id' => $item->id,
            'buyer_id' => $buyer->id,
            'seller_id' => $item->user_id,
            'payment_method' => $request->payment_method,
        ]);

        $item->update([
            'buyer_id' => $buyer->id,
            'status' => 1,
        ]);
        return redirect()->route('mypage');
    }
}
