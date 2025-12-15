@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/order.css') }}">
@endsection

@section('content')
<div class="content">
    <form action="">
        <div class="content__group">
            <div class="content__item">
                <p class="item__box">商品画像</p> <!--商品画像_仮置き-->
                <h1 class="item__name">商品名</h1>
                <p class="item_price">&yen; 47,000</p>
            </div>
            <div class="content__payment-method">
                <p class="payment-method">支払い方法</p>
                <select name="payment_method">
                    <option>コンビニ払い</option>
                    <option>カード払い</option>
                </select>
            </div>
            <div class="content__address">
                <p class="address__title">配送先</p>
                <a class="address__edit" href="/purchase/address/i{tem_id}">変更する</a>
                <p class="address__text">〒 XXX-YYYY</p>
                <p class="address__text">ここには住所と建物が入ります</p>
            </div>
        </div>
        <div class="content__group">
            <div class="order-confirm">
                <span class="order-confirm__text">商品代金</span>
                <span class="order-confirm__text">&yen; 47,000</span>
            </div>
            <div class="order-confirm">
                <span class="order-confirm__text">支払い方法</span>
                <span class="order-confirm__text">コンビニ払い</span>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </div>
    </form>
</div>
@endsection