<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Like;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    //共通化
    protected function prepareIndexData(Request $request): array
    {
        $query = Item::query();

        if (auth()->check()) {
            $query->where('user_id', '!=', auth()->id());
        }

        $items = $query->get();

        $likeItems = Like::where('user_id', auth()->id())
            ->with('item')
            ->get();

        $defaultTab = $request->query('tab', 'recommend');

        return [$items, $likeItems, $defaultTab];
    }

    public function index(Request $request){
        [$items, $likeItems, $defaultTab] = $this->prepareIndexData($request);
        return view('index', compact('items', 'likeItems', 'defaultTab'));
    }

    public function mylist(Request $request){
        [$items, $likeItems, $defaultTab] = $this->prepareIndexData($request);
        return redirect()->route('items.index', ['tab' => 'mylist']);
    }

    public function search(Request $request){
        $keyword = $request->input('keyword');

        $items = Item::where('user_id', '!=', auth()->id())
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })->get();

        $likeItems = Like::where('user_id', auth()->id())
            ->whereHas('item', function ($query) use ($keyword) {
                if ($keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                }
            })
            ->with('item')
            ->get();

        $defaultTab = $request->query('tab', 'recommend');

        return view('index', compact('items', 'likeItems', 'defaultTab', 'keyword'));
    }
}
