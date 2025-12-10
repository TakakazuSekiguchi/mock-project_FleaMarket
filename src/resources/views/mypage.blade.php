@extends('layouts.app')

@section('link')
@if(Auth::check())
<!-- <input class="search-form__keyword-input" type="text" name="keyword" placeholder="何をお探しですか？" value="{{ request('keyword') }}"> -->
<input class="search-form__keyword-input" type="text" placeholder="何をお探しですか？" >
<form action="/logout" method="post">
    @csrf
    <button class="button__button">ログアウト</button>
</form>
<a class="button__mypage" href="/mypage">マイページ</a>
<a class="button__putUp" href="/sell">出品</a>
@endif
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="user">
        <div class="user__group">
            <p class="user__icon"></p> <!--アイコン_仮置き-->
            <p class="user__name">ユーザー名</p>
            <a class="button__myProfile" href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
    <div class="tag">
        <div class="tag__group">
            <span class="tag__title">出品した商品</span>
            <span class="tag__title-myList">購入した商品</span>
        </div>
    </div>
    <div class="content__group">
        <div class="content__item">
            <p class="item__box">商品画像</p> <!--商品画像_仮置き-->
            <p class="item__name">商品名</p>
        </div>
        <div class="content__item">
            <p class="item__box">商品画像</p> <!--商品画像_仮置き-->
            <p class="item__name">商品名</p>
        </div>
        <div class="content__item">
            <p class="item__box">商品画像</p> <!--商品画像_仮置き-->
            <p class="item__name">商品名</p>
        </div>
    </div>
</div>
@endsection