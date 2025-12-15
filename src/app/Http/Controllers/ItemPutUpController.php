<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemPutUpController extends Controller
{
    public function index(){
        return view('item_putUp');
    }

    public function store(Request $request){
        Item::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'condition' => $request->condition,
            'name' => $request->name,
            'price' => $request->price,
            'status' => 1,
            'brand' => $request->condition,
            'description' => $request->condition,
        ]);

        return redirect()->route('items.store');
    }
}
