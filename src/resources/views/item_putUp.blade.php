@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item_putUp.css') }}">
@endsection

@section('content')
<div class="putUp__content">
    <form class="form__item" action="{{ route('items.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="putUp__heading">
            <h1 class="item-detail__title-h1">商品の出品</h1>
            <p class="item-image">商品画像</p>
            <div class="item-image__select">
                <label class="button__image__select">
                    画像を選択する
                    <input type="file" name="image" hidden>
                </label>
            </div>
            @error('image')
            <div class="form__error">
                {{ $errors->first('image') }}
            </div>
            @enderror
        </div>
        <div class="item-detail">
            <h2 class="item-detail__title">商品の詳細</h2>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">カテゴリー</p>
            </div>
            <div class="form__group-content">
                @error('category_ids')
                <div class="form__error">
                    {{ $errors->first('category_ids') }}
                </div>
                @enderror
                <div class="form__category">
                    @foreach ($categories as $category)
                        <input
                            type="checkbox"
                            name="category_ids[]"
                            value="{{ $category->id }}"
                            id="category_{{ $category->id }}"
                            class="category-input"
                        >
                        <label for="category_{{ $category->id }}" class="category-label">
                        {{ $category->name }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">商品の状態</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <select class="select__condition" name="condition">
                        <option value="">選択してください</option>
                        <option value=1>良好</option>
                        <option value=2>目立った傷や汚れなし</option>
                        <option value=3>やや傷や汚れあり</option>
                        <option value=4>状態が悪い</option>
                    </select>
                </div>
                @error('condition')
                <div class="form__error">
                    {{ $errors->first('condition') }}
                </div>
                @enderror
            </div>
        </div>
        <div class="item-explanation">
            <h3 class="item-explanation__title">商品名と説明</h3>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <p class="form__label-item">商品名</p>
            </div>
            <div class="form__group-content">
                <div class="form__input">
                    <input class="form__input-text" type="text" name="name" value="{{ old('name') }}">
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
                @error('description')
                <div class="form__error">
                    {{ $errors->first('description') }}
                </div>
                @enderror
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
                @error('price')
                <div class="form__error">
                    {{ $errors->first('price') }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection