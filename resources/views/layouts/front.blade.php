<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <title>{{ config('app.name') }}</title>
  <meta name="description" content="{{ config('app.description') }}">
  <meta name="author" content="{{ config('app.author') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  <link rel="favicon" content="{{ asset('favicon.ico') }}">
  <link rel="icon" content="{{ asset('img/favicons/128.png') }}" type="image/png">
  <link rel="apple-touch-icon" href="{{ asset('img/favicons/192.png') }}">
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Mono&display=swap">
  <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css">
  <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
  <link href="{{ mix('/public/css/front.css') }}">
</head>

<body>
  <div id="app">
    <v-app id="inspire">
      <v-app-bar app flat>
        {{-- <v-app-bar-nav-icon></v-app-bar-nav-icon> --}}
        <v-toolbar-title>
          <v-btn text large class="logo" href="{{ url('/') }}">
            {{ config('app.name') }}
          </v-btn>
        </v-toolbar-title>
        <v-btn href="{{ route('login') }}">Login</v-btn>
        <v-btn href="{{ route('register') }}">Register</v-btn>
      </v-app-bar>
      <v-main>
        @yield('content')
      </v-main>
    </v-app>
  </div>
  @yield('footer_scripts')
  <script async defer>
  new Vue({
    el: '#app',
    vuetify: new Vuetify(),
    created() {
      this.$vuetify.theme.dark = true;
    }
  });
  </script>
</body>

</html>
