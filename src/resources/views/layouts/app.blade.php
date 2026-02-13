<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mock-project_FleaMarket</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
</head>

<body>
    @php
        $hidePages = ['login', 'register'];
    @endphp
    <header class="header">
        <div class="header__inner">
            <a href="/">
                <img class="header__img" src="{{ asset('images/logo.png') }}" alt="logo" >
            </a>
            @if (!Route::is($hidePages))
                @guest
                    <form class="form__search" action="{{ route('items.search') }}" method="get">
                        <input class="search-form__keyword-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    </form>
                    <div class="header__nav">
                        <a class="button__login" href="/login">ログイン</a>
                        <a class="button__mypage" href="/mypage">マイページ</a>
                        <a class="button__putUp" href="/sell">出品</a>
                    </div>
                @endguest
                @auth
                    <form class="form__search" action="{{ route('items.search') }}" method="get">
                        <input class="search-form__keyword-input" type="text" name="keyword" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                    </form>
                    <div class="header__nav">
                        <form class="form__logout" action="/logout" method="post">
                            @csrf
                            <button class="button__logout">ログアウト</button>
                        </form>
                        <a class="button__mypage" href="/mypage">マイページ</a>
                        <a class="button__putUp" href="/sell">出品</a>
                    </div>
                @endauth
            @endif
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>