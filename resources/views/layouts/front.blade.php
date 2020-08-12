<!doctype html>
@php

$config = [
'locale' => str_replace('_', '-', app()->getLocale()),
'name' => config('app.name'),
'url' => config('app.url'),
'description' => config('app.description'),
];

@endphp
<html lang="{!! $config['locale'] !!}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <title>{{ config('app.name') }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ config('app.description') }}">
  <meta name="author" content="{{ config('app.author') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <script>
    window.config = @json($config)

  </script>
  <link rel="stylesheet" href="{{ mix('/css/front.css') }}">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Mono|Material+Icons">
</head>
<body>
  <div id="app">
    @yield('content')
  </div>
  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/front.js') }}"></script>
</body>

</html>
