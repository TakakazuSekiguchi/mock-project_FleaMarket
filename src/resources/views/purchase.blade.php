@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<form class="purchase__form" action="{{ route('purchase.checkout', ['item' => $item->id]) }}" method="POST">
    @csrf
    <div class="purchase__info">
        <div class="purchase__item">
            <img class="item__box" src="{{ asset('storage/' . $item->image) }}" alt="商品画像">
            <div class="item__info">
                <h1 class="item__name">{{ $item->name }}</h1>
                <p class="item__price">&yen; {{ $item->price }}</p>
            </div>
        </div>
        <div class="purchase__payment-method">
            <p class="payment-method__title">支払い方法</p>
            <select class="payment-method__select" name="payment_method" id="payment_method">
                <option value="">選択してください</option>
                <option value="0">コンビニ払い</option>
                <option value="1">カード払い</option>
            </select>
            @error('payment_method')
            <div class="form__error">
                {{ $errors->first('payment_method') }}
            </div>
            @enderror
        </div>
        <div class="purchase__address">
            <div class="address__info">
                <p class="address__title">配送先</p>
                <p class="address__text">〒 {{ $address?->postal_code }}</p>
                <p class="address__text">{{ $address?->address }} {{ $address?->building }}</p>
                @if($hasAddressError)
                    <div class="form__error">
                        住所は、必須項目です
                    </div>
                @endif
            </div>
            <div class="address__link">
                <a class="address__edit" href="{{ route('address.edit', $item->id) }}">変更する</a>
            </div>
        </div>
    </div>
    <div class="purchase__confilm">
        <div class="purchase__confilm-price">
            <span class="purchase__confilm-text">商品代金</span>
            <span class="purchase__confilm-text">&yen; {{ $item->price }}</span>
        </div>
        <div class="purchase__confilm-payment_method">
            <span class="purchase__confilm-text">支払い方法</span>
            <span class="purchase__confilm-text" id="payment_display">未選択</span>
        </div>
        @php
            $isSeller = Auth::id() === $item->user_id;
            $isSold   = $item->status === 1;
        @endphp
        <div class="form__button">
            <button 
                class="button-submit" 
                type="submit" 
                @if ($hasAddressError || $isSeller || $isSold)
                    disabled
                @endif
            >
                購入する
            </button>
            @if ($isSold)
                <p class="text-danger">この商品は購入済みです</p>
            @elseif ($isSeller)
                <p class="text-danger">出品者は自分の商品を購入できません</p>
            @endif
        </div>
    </div>
</form>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const select = document.getElementById('payment_method');
    const display = document.getElementById('payment_display');

    select.addEventListener('change', () => {
        const value = select.value; // "0" or "1" or ""
        const selectedText = select.options[select.selectedIndex].text;

        if (value === '') {
            display.textContent = '未選択';
        } else {
            display.textContent = selectedText;
        }
    });
});
</script>
@endsection