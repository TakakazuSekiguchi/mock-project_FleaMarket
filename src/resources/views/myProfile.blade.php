@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/myProfile.css') }}">
@endsection

@section('content')
<div class="myProfile__content">
    <div class="myProfile__heading">
        <h1 class="myProfile__title">プロフィール設定</h1>
    </div>
    <form class="form" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="user__group">
            @if(auth()->user()->icon)
                <img class="user__icon" src="{{ asset('storage/' . $user->icon) }}" alt="プロフィール画像">
            @else
                <p class="user__icon"></p>
            @endif
            <label class="button__image__select">
                画像を選択する
                <input type="file" name="icon" hidden>
            </label>
        </div>
        @error('icon')
        <div class="form__error">
            {{ $errors->first('icon') }}
        </div>
        @enderror
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">ユーザー名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="name" value="{{ $user['name'] }}">
                </div>
                @error('name')
                <div class="form__error">
                    {{ $errors->first('name') }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">郵便番号</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}">
                </div>
                @error('postal_code')
                <div class="form__error">
                    {{ $errors->first('postal_code') }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">住所</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="address" value="{{ old('address', $address->address ?? '') }}">
                </div>
                @error('address')
                <div class="form__error">
                    {{ $errors->first('address') }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">建物名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="building" value="{{ old('building', $address->building ?? '') }}">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection