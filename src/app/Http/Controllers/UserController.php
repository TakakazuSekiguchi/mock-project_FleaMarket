<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function mypage(){
        return view('mypage');
    }

    public function edit(){
        return view('myProfile');
    }
}
