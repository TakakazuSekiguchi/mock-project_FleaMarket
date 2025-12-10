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
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="content__item">
        <p class="item__box">商品画像</p> <!--商品画像_仮置き-->
    </div>
    <div class="content__detail">
        <div class="detail__item">
            <h1 class="detail__title">商品名がここに入る</h1>
            <p class="detail__brand">ブランド名</p>
            <p class="detail__price">&yen;47,000</p> <!--金額_仮置き-->
            <span class="detail__tax">(税込み)</span>
            <span>いいねマーク</span> <!--いいね画像_仮置き-->
            <span>コメントマーク</span> <!--コメント画像_仮置き-->
            <a class="bottun-submit" href="/purchase/{item_id}">購入手続きへ</a>
        </div>
        <div class="detail__description">
            <h2 class="detail__title">商品説明</h2>
            <p class="detail__color">カラー：グレー</p>
            <p class="detail__text">新品</p>
            <p class="detail__text">商品の状態は良好です。傷もありません。購入後、即配送いたします。</p>
        </div>
        <div class="detail__info">
            <h3 class="detail__title">商品の情報</h3>
            <p class="detail__category-title">カテゴリー</p>
            <span class="detail__category">複数のカテゴリがここに入る</span>
            <p class="detail__condition-title">商品の状態</p>
            <span class="detail__condition">良好</span>
        </div>
        <div class="detail__comment">
            <h4 class="detail__title">コメント(1)</h4>
            <p class="comment__icon">ユーザーのアイコン画像</p>
            <span class="comment__userName">admin</span>
            <p class="comment__text">こちらにコメントが入ります。</p>
        </div>
        <div class="form__comment">
            <h5 class="detail__title">商品へのコメント</h5>
            <form class="comment__button" action="">
                <textarea name="" id=""></textarea>
                <button class="bottun-submit" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection