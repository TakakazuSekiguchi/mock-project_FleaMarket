<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //プロフィール編集画面を表示
    public function edit(){
        $user = auth()->user();
        $address = $user->addresses;
        return view('myProfile', compact('user', 'address'));
    }

    //プロフィール編集画面のフォーム送信
    public function update(ProfileRequest $request){
        $user = auth()->user();

        if($request->hasFile('icon')){
            //既存画像がある場合は削除する
            if($user->icon){
                Storage::disk('public')->delete($user->icon);
            }

            //既存画像がない場合は新規で登録する
            $path = $request->file('icon')->store('profile', 'public');
            $user->icon = $path;
            $user->save();
        }

        $address = Address::updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );
        return redirect()->route('items.mylist');
    }

    protected function prepareMyPageData(Request $request): array
    {
        $user = auth()->user();

        // 出品商品
        $sellingItems = Item::where('user_id', $user->id)->get();

        // 購入商品（購入者が自分 & 購入済み）
        $purchasedItems = Item::where('buyer_id', $user->id)
            ->where('status', 1)
            ->get();

        // デフォルトタブ
        $defaultTab = $request->query('page', 'sell');

        return [$user, $sellingItems, $purchasedItems, $defaultTab];
    }

    //マイページを表示
    public function index(Request $request){
        [$user, $sellingItems, $purchasedItems, $defaultTab] = $this->prepareMyPageData($request);
        return view('mypage', compact('user', 'sellingItems', 'purchasedItems', 'defaultTab'));
    }

    public function sell(Request $request){
        [$user, $sellingItems, $purchasedItems, $defaultTab] = $this->prepareMyPageData($request);
        return redirect()->route('mypage.index', ['page' => 'sell']);
    }

    public function buy(Request $request){
        [$user, $sellingItems, $purchasedItems, $defaultTab] = $this->prepareMyPageData($request);
        return redirect()->route('mypage.index', ['page' => 'buy']);
    }
}