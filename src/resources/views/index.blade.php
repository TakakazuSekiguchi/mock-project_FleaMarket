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
                    <img class="item__box" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
                    <a class="item__name" href="{{ route('items.show', $item->id) }}">
                        {{ $item->name }}
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <input type="radio" id="tab2" name="TAB">
        <label class="tab-boder" for="tab2">マイページ</label>
        <div class="tab-content">
            @if(Auth::check())
            <div class="content__flex">
                <!-- <div class="content__item">
                    <img class="item__box" src="{{ asset('images/logo.png') }}">
                    <a class="item__name">マイページ商品名</a>
                </div> -->
                @foreach($likes as $like)
                <div class="content__item">
                    <img class="item__box" src="{{ asset('storage/' . $like->item->image) }}" alt="商品画像">
                    <a class="item__name" href="{{ route('items.show', $like->item->id) }}">
                        {{ $like->item->name }}
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection