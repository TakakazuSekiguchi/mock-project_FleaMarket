<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Item $item){
        return view('order');
    }

    public function address(){
        return view('address');
    }
}
