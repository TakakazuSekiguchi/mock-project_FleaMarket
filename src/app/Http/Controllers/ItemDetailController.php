<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;

class ItemDetailController extends Controller
{
    public function show(Item $item){
        $item = Item::with('categories')
            ->with('user')
            ->withCount('likes')
            ->withCount('comments')
            ->findOrFail($item->id);

        $comments = Comment::where('item_id', "{$item->id}")->with('user')->get();

        return view('item_detail', compact('item', 'comments'));
    }

    public function toggleLike(Item $item){
        if(!auth()->check()){
            return redirect()->route('login');
        }

        $user = auth()->user();
        $like = Like::where('user_id', $user->id)->where('item_id', $item->id)->first();

        if($like){
            $like->delete();
        }else{
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
        }

        return back();
    }

    public function store(CommentRequest $request, Item $item){
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'comment' => $request->comment,
        ]);
        return back();
    }
}
