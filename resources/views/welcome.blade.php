<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@{{ page_name }} — A Laravel/Vue.js Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
</head>

<body class="no-js full-height">
    <div id="app">
        <v-app>
            <v-main>
                <v-container>
                    @if (Route::has('login'))
                    <v-list data-pos="abs" class="top-right">
                        @auth
                        <a href="{{ url('/admin') }}">Dashboard</a>
                        @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                        @endauth
                    </v-list>
                    @endif

                    <main class="content full-height">
                        <v-card class="text-center">
                            <v-card-title>
                                <h1>@{{ page_name }}</h1>
                            </v-card-title>
                            <v-card-text>
                                <v-subheader>Powered by</v-subheader>
                                <p>
                                    <v-img src="{{ url('v-img/logos/laravel.svg') }}" alt="Laravel" />
                                    <v-img src="{{ url('imv-g/logos/vuejs.svg') }}" alt="Vue.js" />
                                </p>
                            </v-card-text>
                        </v-card>
                    </main>
                </v-container>
            </v-main>
        </v-app>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: () => ({
                vuetify: new Vuetify(),
                page_name: 'Welcome',
                top_nav: [
                    {
                        name: 'Dashboard',
                        url: '/dashboard',
                    }, {
                        name: 'Login',
                        url: '/login',
                    }, {
                        name: 'Register',
                        url: '/register',
                    }
                ]
            }),
            beforeCreate() {
                this.page_name = "{{ env('APP_NAME') }}";
            }
        });
    </script>
</body>

</html>
