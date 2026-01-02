<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemPutUpController extends Controller
{
    public function create(){
        $categories = Category::all();
        return view('item_putUp', compact('categories'));
    }

    public function store(Request $request){
        $path = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => Auth::id(),
            'condition' => $request->condition,
            'name' => $request->name,
            'price' => $request->price,
            'status' => 1,
            'brand' => $request->brand,
            'description' => $request->description,
            'image' => $path,
        ]);

        // カテゴリを紐付け（中間テーブルに保存）
        $item->categories()->attach($request->category_ids);
        
        return redirect()->route('items.store');
    }
}
