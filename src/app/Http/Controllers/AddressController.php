<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Http\Requests\AddressRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function edit(Item $item){
        $user = auth()->user();
        $item = Item::findOrFail($item->id);
        $address = Address::where('user_id', "{$user->id}")->first();
        return view('address', compact('address'));
    }

    public function update(AddressRequest $request){
        $user = auth()->user();
        $address = Address::where('user_id', "{$user->id}")->first();
        $address->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);
        return redirect()->back()->with('success', '住所を更新しました');
    }
}
