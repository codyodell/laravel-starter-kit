<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <meta name="theme-color" content="#50ffca">
    <meta name="google" content="notranslate">
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="generator" content="VS Code">
    <meta name="author" content="{{ config('app.author') }}">
    <link rel="icon" type="image/png" content="{{ asset('img/favicons/192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicons/192.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script type="application/javascript">
        var CMWD_APP = {};
        CMWD_APP.APP_URL = '{{ env('APP_URL') }}';
    </script>
</head>
