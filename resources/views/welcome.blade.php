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
    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <script type="application/javascript">
        window.config = @json($config);
    </script>
</head>

<body>
    <div id="app">
        <v-app>
            <v-main>
                <v-toolbar dark dense>
                    <v-toolbar-title>
                        <v-btn text large title="{{ app_name }}" @click="$router.push({name: 'welcome'})">
                            <span>{{ app_name }}</span>
                        </v-btn>
                    </v-toolbar-title>
                    <v-spacer></v-spacer>
                    @if(Route::has('login'))
                    <v-toolbar-items>
                        @auth
                        <v-btn small href="{{ url('/admin') }}">Dashboard</v-btn>
                        @else
                        <v-btn small href="{{ route('login') }}">Login</v-btn>
                        <v-btn small href="{{ route('register') }}">Register</v-btn>
                        @endauth
                    </v-toolbar-items>
                    @endif
                </v-toolbar>
                <v-container fluid>
                    <v-row
                           class="fill-height"
                           align="center"
                           justify="center">
                        <v-col cols="12" justify-center>
                            <div class="text-center">
                                <h4>Powered By</h4>
                                <img src="{{ asset('img/logos/laravel.svg') }}" width="240px" alt="Laravel">
                                <img src="{{ asset('img/logos/vuejs.svg') }}" width="240px" alt="Vue.js">
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-main>
        </v-app>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            app_name: 'PWA Shop',
            nav_top: []
        }),
        mounted() {
            if(config.logged_in) {

            } else {
                
            }
        },
    })
    </script>
</body>

</html>
