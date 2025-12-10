<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemPutUpController extends Controller
{
    public function putUp(){
        return view('item_putUp');
    }
}
