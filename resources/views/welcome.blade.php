@php

$user = Auth::user();
$user_id = Auth::id();

$config = [
'lang' => str_replace('_', '-', app()->getLocale()),
'app_name' => config('app.name', 'PWA Shop'),
'app_url' => config('app.url'),
'app_description' => config('app.description'),
'header_styles' => [
'google_fonts_roboto' => 'https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900',
'vuetify' => 'https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css',
'material_design_icons' => 'https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css',
],
'logged_in' => !!$user_id,
];

@endphp
<!doctype html>
<html lang="{!! $config['lang'] !!}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="author" content="{{ config('app.author') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script type="application/javascript">
        window.config = @json($config);
    </script>
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Mono&amp;display=swap"
          rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="{{  mix('css/front.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <v-app id="inspire">
            <v-main>
                <v-app-bar app flat>
                    <v-app-bar-nav-icon></v-app-bar-nav-icon>
                    <v-toolbar-title class="pa-0">
                        <v-btn text large class="logo" title="{{ config('app.name') }}" href="{{ url('/') }}">
                            <v-icon left>mdi-storefront-outline</v-icon>
                            <span>{{ $config['app_name'] }}</span>
                        </v-btn>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    @auth
                    <v-btn small text href="{{ url('/admin') }}">Dashboard</v-btn>
                    @else
                    <v-btn small text href="{{ route('login') }}">Login</v-btn>
                    <v-btn small text href="{{ route('register') }}">Register</v-btn>
                    @endauth
                </v-app-bar>
                <v-container fluid class="fill-height">
                    <v-row align="center" justify="center">
                        <v-col cols="12" sm="8" md="4">
                            <v-sheet class="pa-4 text-center">
                                <h4>Powered By</h4>
                                <img src="{{ asset('img/logos/laravel.svg') }}" height="140px" alt="Laravel">
                                <img src="{{ asset('img/logos/vuejs.svg') }}" height="140px" alt="Vue.js">
                            </v-sheet>
                        </v-col>
                    </v-row>
                </v-container>
                <v-footer app class="text-center" align="center">
                    <v-icon>mdi-facebook</v-icon>
                    <v-icon>mdi-twitter</v-icon>
                    <v-icon>mdi-facebook</v-icon>
                </v-footer>
            </v-main>
        </v-app>
    </div>
    <script src="{{ mix('js/front.js') }}"></script>
</body>

</html>
