<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel/Vue.js &mdash; MySQL REST Example</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <style>
        html, body {
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            color: #35353e;
        }

        body {
            font-family: 'Roboto', sans-serif;
            font-weight: 400;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-rel {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 0.625em;
            top: 1.375em;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 5em;
        }

        .m-b-md {
            margin-bottom: 0.25em;
        }

        .m-b-md.title {
            display: flex;
            flex-direction: row;
        }
        
        .icon-logo {
            display: inline-block;
            vertical-align: baseline;
            height: 100%;
            max-height: 12rem;
        }

        .icon-logo + .icon-logo {
            margin-left: 1.25em;
        }

        .btn {
            padding: 0.375em 1.1875em;
            font-size: 0.875em;
            color: rgba(0, 0, 0, 0.75);
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="no-js">
<div class="flex-center position-rel full-height">
    @if (Route::has('login'))
        <div class="top-right">
            <div class="body">
                @auth
                    <a href="{{ url('/admin') }}" class="btn">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn">Login</a>
                    <a href="{{ route('register') }}" class="btn">Register</a>
                @endauth
            </div>
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            <img class="icon-logo logo-laravel" src="{{ url('img/logos/laravel.svg') }}">
            <img class="icon-logo logo-vue" src="{{ url('img/logos/vuejs.svg') }}">
        </div>

        <div class="links">
            <h1>MySQL Web App &mdash; REST API</h1>
            <p class="text--secondary">Powered by Laravel, VueJS & Material Design</p>
        </div>
    </div>
</div>
</body>
</html>
