@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="content">
    <div class="tab-switch">
        <input type="radio" id="tab1" name="TAB"
            {{ $defaultTab !== 'mylist' ? 'checked' : '' }}>
        <label class="tab-boder" for="tab1">おすすめ</label>
        <div class="tab-content">
            <div class="content__flex">
                @foreach($items as $item)
                <div class="content__item">
                    <a class="item__card" href="{{ route('items.show', $item->id) }}">
                        <img class="item__box" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
                        <p class="item__name">{{ $item->name }}</p>
                        @if($item->status == 1)
                            <p class="item__sold">Sold</p>
                        @endif
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <input type="radio" id="tab2" name="TAB"
            {{ $defaultTab === 'mylist' ? 'checked' : '' }}>
        <label class="tab-boder" for="tab2">マイリスト</label>
        <div class="tab-content">
            @if(Auth::check())
            <div class="content__flex">
                @foreach($likeItems as $likeItem)
                <div class="content__item">
                    <a class="item__card" href="{{ route('items.show', $likeItem->item->id) }}">
                        <img class="item__box" src="{{ asset('storage/' . $likeItem->item->image) }}" alt="商品画像">
                        <p class="item__name">{{ $likeItem->item->name }}</p>
                        @if($likeItem->item->status == 1)
                            <p class="item__sold">Sold</p>
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