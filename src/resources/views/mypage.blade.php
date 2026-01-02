@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="user">
        <div class="user__group">
            <div class="user__group-icon">
                @if(auth()->user()->icon)
                    <img class="user__icon" src="{{ asset('storage/' . $user->icon) }}" alt="プロフィール画像">
                @else
                    <p class="user__icon"></p>
                @endif
                <p class="user__name">{{ $user->name }}</p>
            </div>
            <div class="user__group-myProfile">
                <a class="button__myProfile" href="/mypage/profile">プロフィールを編集</a>
            </div>
        </div>
    </div>
    <div class="tab-switch">
        <input type="radio" id="tab1" name="TAB" checked>
        <label class="tab-boder" for="tab1">出品した商品</label>
        <div class="tab-content">
            <div class="content__flex">
                @foreach($items as $item)
                <div class="content__item">
                    <img class="item__box" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
                    <a class="item__name">{{ $item->name }}</a>
                </div>
                @endforeach
            </div>
        </div>
        <input type="radio" id="tab2" name="TAB">
        <label class="tab-boder" for="tab2">購入した商品</label>
        <div class="tab-content">
            @if(Auth::check())
            <div class="content__flex">
                <div class="content__item">
                    <a class="item__box">購入した商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">購入した商品名</a>
                </div>
                <div class="content__item">
                    <a class="item__box">購入した商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">購入した商品名</a>
                </div>
                <div class="content__item">
                    <a class="item__box">購入した商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">購入した商品名</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection