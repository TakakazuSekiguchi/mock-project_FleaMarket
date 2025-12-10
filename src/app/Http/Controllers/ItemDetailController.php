<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemDetailController extends Controller
{
    public function item(){
        return view('item_detail');
    }
}
