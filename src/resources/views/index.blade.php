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
@else
<!-- <input class="search-form__keyword-input" type="text" name="keyword" placeholder="何をお探しですか？" value="{{ request('keyword') }}"> -->
<input class="search-form__keyword-input" type="text" placeholder="何をお探しですか？" >
<a class="button__login" href="/login">ログイン</a>
<a class="button__mypage" href="/mypage">マイページ</a>
<a class="button__putUp" href="/sell">出品</a>
@endif
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="tag">
        <div class="tag__group">
            <span class="tag__title">おすすめ</span>
            <span class="tag__title-myList">マイリスト</span>
        </div>
    </div>
    <div class="content__group">
        <div class="content__item">
            <a class="item__box">商品画像</a> <!--商品画像_仮置き-->
            <a class="item__name">商品名</a>
        </div>
        <div class="content__item">
            <a class="item__box">商品画像</a> <!--商品画像_仮置き-->
            <a class="item__name">商品名</a>
        </div>
        <div class="content__item">
            <a class="item__box">商品画像</a> <!--商品画像_仮置き-->
            <a class="item__name">商品名</a>
        </div>
    </div>
</div>
@endsection