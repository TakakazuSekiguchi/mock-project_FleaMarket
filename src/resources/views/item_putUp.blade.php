@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_putUp.css') }}">
@endsection

@section('content')
<div class="putUp__content">
    <div class="putUp__heading">
        <h1 class="item-detail__title">商品の出品</h1>
        <p class="item-image">商品画像</p>
        <div class="item-image__select">
            <a class="button__image__select" href="">画像を選択する</a>
        </div>
    </div>
    <form class="form__item" action="/sell" method="post">
        @csrf
        <div class="item-detail">
            <div class="">
                <h2 class="item-detail__title">商品の詳細</h2>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">カテゴリー</p>
            </div>
            <div class="form__group-content">
                <div class="form__category">
                    <input type="radio" name="category_id" value="2">家電</input>
                    <!-- <input type="checkbox" id="cat1" name="categories[]" value="1">
                    <label class="button__category" for="cat1">ファッション</label>
                    <input type="checkbox" id="cat2" name="categories[]" value="2">
                    <label class="button__category" for="cat2">家電</label>
                    <input type="checkbox" id="cat3" name="categories[]" value="3">
                    <label class="button__category" for="cat3">インテリア</label>
                    <input type="checkbox" id="cat4" name="categories[]" value="4">
                    <label class="button__category" for="cat4">レディース</label>
                    <input type="checkbox" id="cat5" name="categories[]" value="5">
                    <label class="button__category" for="cat5">メンズ</label>
                    <input type="checkbox" id="cat6" name="categories[]" value="6">
                    <label class="button__category" for="cat6">コスメ</label>
                    <input type="checkbox" id="cat7" name="categories[]" value="7">
                    <label class="button__category" for="cat7">本</label>
                    <input type="checkbox" id="cat8" name="categories[]" value="8">
                    <label class="button__category" for="cat8">ゲーム</label>
                    <input type="checkbox" id="cat9" name="categories[]" value="9">
                    <label class="button__category" for="cat9">スポーツ</label>
                    <input type="checkbox" id="cat10" name="categories[]" value="10">
                    <label class="button__category" for="cat10">キッチン</label>
                    <input type="checkbox" id="cat11" name="categories[]" value="11">
                    <label class="button__category" for="cat11">ハンドメイド</label>
                    <input type="checkbox" id="cat12" name="categories[]" value="12">
                    <label class="button__category" for="cat12">アクセサリー</label>
                    <input type="checkbox" id="cat13" name="categories[]" value="13">
                    <label class="button__category" for="cat13">おもちゃ</label>
                    <input type="checkbox" id="cat14" name="categories[]" value="14">
                    <label class="button__category" for="cat14">ベビー・キッズ</label> -->
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">商品の状態</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <select name="condition">
                        <option>選択してください</option>
                        <option value=1>良好</option>
                        <option value=2>目立った傷や汚れなし</option>
                        <option value=3>やや傷や汚れあり</option>
                        <option value=4>状態が悪い</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="item-explanation">
            <div class="">
                <h3 class="item-explanation__title">商品名と説明</h3>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">商品名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="name" value="{{ old('name') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">ブランド名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="brand" value="{{ old('brand') }}">
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">商品の説明</p>
            </div>
            <div class="form__group-content">
                <div class="form__textarea">
                    <textarea class="form__textarea-text" name="description"></textarea>
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">販売価格</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="price" value="{{ old('price') }}" placeholder="&yen;">
                </div>
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection