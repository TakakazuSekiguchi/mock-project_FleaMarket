<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Http\Request;

class ItemPutUpController extends Controller
{
    public function create(){
        $categories = Category::all();
        return view('item_putUp', compact('categories'));
    }

    public function store(ExhibitionRequest $request){
        //【本番用】画像のpathをstorage/itemsで管理
        $path = $request->file('image')->store('items', 'public');

        //【seederファイル用】画像オリジナルファイル名をstorage/itemsに取り込む際に使用
        // $path = $request->file('image')->getClientOriginalName();
        // request()->file('image')->move('storage/items', $path);

        $item = Item::create([
            'user_id' => auth()->id(),
            'condition' => $request->condition,
            'name' => $request->name,
            'price' => $request->price,
            'status' => 0,
            'brand' => $request->brand,
            'description' => $request->description,
            'image' => $path,
        ]);

        // カテゴリを紐付け（中間テーブルに保存）
        $item->categories()->attach($request->category_ids);
        
        return redirect()->route('mypage.sell');
    }
}
