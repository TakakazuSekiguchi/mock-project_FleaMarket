<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Address;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //プロフィール編集画面を表示
    public function edit(){
        $user = auth()->user();
        $address = $user->addresses;
        return view('myProfile', compact('user', 'address'));
    }

    //プロフィール編集画面のフォーム送信
    public function update(Request $request){
        $user = auth()->user();

        if($request->hasFile('image')){
            //既存画像がある場合は削除する
            if($user->icon){
                Storage::disk('public')->delete($user->icon);
            }

            //既存画像がない場合は新規で登録する
            $path = $request->file('image')->store('profile', 'public');
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
        return redirect()->back()->with('success', 'プロフィールを更新しました');
    }

    //マイページを表示
    public function index(Request $request){
        $user = Auth::user();
        $page = Item::query();
        $items = Item::where('user_id', $user->id)->get();

        return view('mypage', compact('user', 'items', 'page'));
    }
}
