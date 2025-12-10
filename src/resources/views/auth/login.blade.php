@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login-form__content">
    <div class="login-form__heading">
        <h1>ログイン</h1>
    </div>
    <form class="form" action="/login" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">メールアドレス</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="email" name="email" value="{{ old('email') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">パスワード</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="password" name="password" >
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="login__link">
        <a class="login__button-submit" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection