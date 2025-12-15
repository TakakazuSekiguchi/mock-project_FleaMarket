@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')
<div class="address__content">
    <div class="address__heading">
        <h1 class="address__title">住所の変更</h1>
    </div>
    <form action="">
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">郵便番号</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="postal_code" value="{{ old('postal_code') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">住所</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="address" value="{{ old('address') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">建物名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="building" value="{{ old('building') }}">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection