@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_detail.css') }}">
@endsection

@section('content')
@php
    $hidePages = ['login', 'register'];
@endphp
<div class="content">
    <div class="content__item">
        <img class="item__box" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
    </div>
    <div class="content__detail">
        <div class="detail__item">
            <h1 class="detail__title-h1">{{ $item->name }}</h1>
            <p class="detail__brand">{{ $item->brand }}</p>
            <p class="detail__price">&yen;{{ $item->price }}</p>
            <p class="detail__tax">(税込)</p>
            @if($item->status == 1)
                <p class="item_sold">sold</p>
            @endif
            <div class="like__comment">
                @if(Auth::id() !== $item->user_id)      
                    <form class="like__form" action="{{ route('items.like', $item) }}" method="post">
                        @csrf
                        <button type="submit" class="like__button">
                            <img class="img__like" src="{{ asset($item->isLikedBy(auth()->user()) ? 'images/heart-logo_pink.png' : 'images/heart-logo_default.png') }}" alt="いいね" >
                            <p class="like__count">{{ $item->likes_count }}</p>
                        </button>
                    </form>
                @else
                    <div class="like__button-seller">
                        <img class="img__like-seller" src="{{ asset($item->isLikedBy(auth()->user()) ? 'images/heart-logo_pink.png' : 'images/heart-logo_default.png') }}" alt="いいね" >
                        <p class="like__count-seller">{{ $item->likes_count }}</p>
                    </div>
                @endif
                <div class="comment__group">
                    <img class="img__comment" src="{{ asset('images/comment-logo.png') }}" alt="コメント" >
                    <p class="comment__count">{{ $item->comments_count }}</p>
                </div>
            </div>
            @if(Auth::id() !== $item->user_id)
                @if($item->status == 1)
                    <p class="text-danger">※この商品はすでに購入されています</p>
                @else
                    <!-- 出品者以外が購入可能 -->
                    <a class="button-submit-buy" href="{{ route('purchase.show', $item->id) }}">購入手続きへ</a>
                @endif
            @else
                <p class="text-danger">※出品者は自分の商品を購入できません</p>
            @endif
        </div>
        <div class="detail__description">
            <h2 class="detail__title-h2">商品説明</h2>
            <p class="detail__text">{{ $item->description }}</p>
        </div>
        <div class="detail__info">
            <h3 class="detail__title-h3">商品の情報</h3>
            <div class="detail__category">
                <p class="detail__category-title">カテゴリー</p>
                @foreach($item->categories as $category)
                    <span class="category-label">{{ $category['name'] }}</span>
                @endforeach
            </div>
            <p class="detail__condition-title">商品の状態</p>
            @if($item->condition == 1)
                <span class="detail__condition">良好</span>
            @elseif($item->condition == 2)
                <span class="detail__condition">目立った傷や汚れなし</span>
            @elseif($item->condition == 3)
                <span class="detail__condition">やや傷や汚れあり</span>
            @elseif($item->condition == 4)
                <span class="detail__condition">状態が悪い</span>
            @endif
        </div>
        <div class="detail__comment">
            <h4 class="detail__title-h4">コメント</h4>
            @foreach($comments as $comment)
                <img class="user__icon" src="{{ asset('storage/' . $comment->user->icon) }}" alt="">
                <span class="comment__userName">{{ $comment->user->name }}</span>
                <div class="comment__text">
                    <p class="comment__text-comment">{{ $comment->comment }}</p>
                </div>
            @endforeach
        </div>
        <div class="form__comment">
            <h5 class="detail__title-h5">商品へのコメント</h5>
            @error('comment')
            <div class="form__error">
                {{ $errors->first('comment') }}
            </div>
            @enderror
            @if (!Route::is($hidePages))
                @guest
                    <div class="comment__button">
                        <textarea class="comment__textarea" readonly></textarea>
                        <button class="button-submit" type="submit">コメントを送信する</button>
                    </div>
                @endguest
                @auth
                    <form class="comment__button" action="{{ route('comments.store', $item) }}" method="post">
                        @csrf
                        <textarea class="comment__textarea" name="comment" required></textarea>
                        <button class="button-submit" type="submit">コメントを送信する</button>
                    </form>
                @endauth
            @endif
        </div>
    </div>
</div>
@endsection