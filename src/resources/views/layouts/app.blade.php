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
    <header class="header">
        <div class="header__inner">
            <img class="header__img" src="{{ asset('images/logo.png') }}" alt="logo" >
            @yield('link')
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>