<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>eCommerce Store (Laravel/Vue.js)</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">    
    <style>

    html, body { margin: 0; }
    img + img { margin-left: 1em; }

    body {
        font-family: 'Roboto', sans-serif;
        font-weight: 400;
        background-color: #f0f0f0;
        color: #35353e;
    }

    code, pre, kbd {
        font-family: 'Roboto Mono';
    }
    
    h1 { 
        font-weight: 900; 
    }

    [data-pos="rel"] { position: relative; }
    [data-pos="abs"] { position: absolute; }

    .full-height { height: 100vh; }
    .text-center { text-align: center; }
    .top-right { right: 1rem; top: .875rem; }

    .icon-logo {
        display: inline-block;
        vertical-align: middle;
        height: 100%;
        max-width: 12rem;
        max-height: 12rem;
    }

    .btn,
    nav > a {
        padding: 0.375em 1.1875em;
        font-size: 0.75em;
        color: rgba(0, 0, 0, 0.875);
        text-decoration: none;
        text-transform: uppercase;
    }

    .btn:hover {
        color: rgba(0, 0, 0, 0.925);
        text-decoration: none;
    }

    </style>
</head>
<body class="no-js full-height">
    <div id="app">
        @if (Route::has('login'))
            <nav data-pos="abs" class="top-right">
                @auth
                    <a href="{{ url('/admin') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </nav>
        @endif
        <main class="content full-height">
            <article>
                <header class="text-center">
                    <h1>eCommerce Store (Laravel/Vue.js)</h1>
                    <p class="subheading">Powered by</p>
                    <p>
                        <img src="{{ url('img/logos/laravel.svg') }}" class="icon-logo">
                        <img src="{{ url('img/logos/vuejs.svg') }}" class="icon-logo">
                    </p>
                </header>
            </article>
        </main>
    </div>
</body>
</html>
