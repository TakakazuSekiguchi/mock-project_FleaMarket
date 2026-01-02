<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(){
        $query = Item::query();

        if (Auth::check()) {
            $query->where('user_id', '!=', Auth::id());
        }

        $items = $query->get();
        $likes = Like::where('user_id', auth()->id())->with('item')->get();

        return view('index', compact('items', 'likes'));
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');

        $items = Item::where('user_id', '!=', auth()->id())->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%");
        })->get();

        return view('index', compact('items', 'keyword'));
    }
}
