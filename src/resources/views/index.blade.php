@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="tab-switch">
        <input type="radio" id="tab1" name="TAB" checked>
        <label class="tab-boder" for="tab1">おすすめ</label>
        <div class="tab-content">
            <div class="content__flex">
                @foreach($items as $item)
                <div class="content__item">
                    <a class="item__box">商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">{{ $item->name }}</a>
                </div>
                @endforeach
            </div>
        </div>
        <input type="radio" id="tab2" name="TAB">
        <label class="tab-boder" for="tab2">マイページ</label>
        <div class="tab-content">
            @if(Auth::check())
            <div class="content__flex">
                <div class="content__item">
                    <a class="item__box">マイページ商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">マイページ商品名</a>
                </div>
                <div class="content__item">
                    <a class="item__box">マイページ商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">マイページ商品名</a>
                </div>
                <div class="content__item">
                    <a class="item__box">マイページ商品画像</a> <!--商品画像_仮置き-->
                    <a class="item__name">マイページ商品名</a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection