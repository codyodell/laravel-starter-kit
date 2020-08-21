<!doctype html>
<html lang="@{!! $config['locale'] !!}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }} &mdash; @yield('title')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <meta name="csrf-token" content="{!! csrf_token() !!}">
  <meta name="description" content="{!! config('app.description') !!}">
  <meta name="author" content="{!! config('app.author') !!}">
  <link rel="manifest" href="{!! asset('manifest.json') !!}">
  @isset($config)
  <script>
    window.config = @json($config);

  </script>
  @endisset
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900">
  <!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">-->
  <link rel="stylesheet" href="{{ mix('css/front.css') }}">
</head>
<body>
  <div id="app">
    <v-app>
      @include('partials.nav_drawer')
      <v-main>
        @include('partials.header')
        @yield('content')
        @include('partials.footer')
      </v-main>
      @include('partials.footer_utility')
    </v-app>
  </div>
  <script src="{{ mix('js/manifest.js') }}"></script>
  <script src="{{ mix('js/vendor.js') }}"></script>
  <script src="{{ mix('js/front.js') }}"></script>
</body>

</html>
