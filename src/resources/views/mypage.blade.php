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
        <input type="radio" id="tab1" name="TAB"
            {{ $defaultTab !== 'buy' ? 'checked' : '' }}>
        <label class="tab-boder" for="tab1">出品した商品</label>
        <div class="tab-content">
            <div class="content__flex">
                @foreach($sellingItems as $sellingItem)
                <div class="content__item">
                    <a class="item__card" href="{{ route('items.show', $sellingItem->id) }}">
                        <img class="item__box" src="{{ asset('storage/' . $sellingItem->image) }}" alt="商品画像">
                        <p class="item__name">{{ $sellingItem->name }}</p>
                        @if($sellingItem->status == 1)
                            <p class="item_sold">sold</p>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <input type="radio" id="tab2" name="TAB"
            {{ $defaultTab === 'buy' ? 'checked' : '' }}>
        <label class="tab-boder" for="tab2">購入した商品</label>
        <div class="tab-content">
            @if(Auth::check())
            <div class="content__flex">
                @foreach($purchasedItems as $purchasedItem)
                <div class="content__item">
                    <a class="item__card" href="{{ route('items.show', $purchasedItem->id) }}">
                        <img class="item__box" src="{{ asset('storage/' . $purchasedItem->image) }}" alt="商品画像">
                        <p class="item__name">{{ $purchasedItem->name }}</p>
                        @if($purchasedItem->status == 1)
                            <p class="item_sold">sold</p>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection