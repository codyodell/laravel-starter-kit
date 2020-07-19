<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
<!-- @include('html-head') -->
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google" content="notranslate">
    <meta name="description" content="{{ config('app.description') }}">
    <meta name="generator" content="VS Code">
    <meta name="author" content="{{ config('app.author') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimal-ui">
    <
    <!-- @TODO Preconnect to 3rd Parties -->
    <link  rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,900|Roboto+Mono|Material+Icons&display=swap">
    <link rel="icon" type="image/png" content="{{ asset('img/favicons/192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('img/favicons/192.png') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script type="application/javascript">
        var CMWD_APP = {};
            CMWD_APP.APP_URL = '{{ env('APP_URL') }}';
    </script>
</head>
<body>
    <div id="admin">
        <template>
            <v-app id="inspire">
                <v-navigation-drawer
                    app
                    left
                    clipped
                    v-model="drawer"
                >
                    <v-list dense>
                        @foreach($nav as $n)
                            @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
                                <v-list-item :to="{ name: '{{ $n->routeName }}' }" :exact="false">
                                    <v-list-item-action>
                                        <v-icon>{{ $n->icon }}</v-icon>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                            {{ $n->label }}
                                        </v-list-item-title>
                                    </v-list-item-content>
                                </v-list-item>
                            @else
                                <v-divider></v-divider>
                            @endif
                        @endforeach
                    </v-list>
                </v-navigation-drawer>
                <v-app-bar app clipped-left>
                    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
                    <v-toolbar-title>{{ config('app.name') }}</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-menu offset-y>
                        <v-menu-item>
                            <template v-slot:activator="{ on, attrs }">
                                <v-avatar size="36px" color="grey lighten-3" v-on="on" v-bind="attrs" dark>
                                    <v-icon>face</v-icon>
                                    {{-- <img src="{{ asset('img/icons/user-male.svg') }}" alt="No Profile Photo" /> --}}
                                </v-avatar>
                            </template>
                            <v-list>
                                <v-list-item @click="clickLogout('{{ route('logout') }}','{{ url('/') }}')">
                                    <v-list-item-title>Logout</v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-menu-item>
                    </v-menu>
                </v-app-bar>
                <v-main>
                    <v-breadcrumbs :items="getBreadcrumbs">
                        <template v-slot:item="props">
                            <v-breadcrumbs-item 
                                exact
                                :to="props.item.to" 
                                :key="props.item.label"
                                :disabled="props.item.disabled"
                            >
                                <template v-slot:divider>
                                    <v-icon>forward</v-icon>
                                </template>
                                @{{ props.item.label }}
                            </v-breadcrumbs-item>
                        </template>
                    </v-breadcrumbs>
                    <v-container fluid>
                        <transition name="fade">
                            <router-view></router-view>
                        </transition>
                    </v-container>
                    <v-footer class="text-right">
                        <span>&copy; {{ date('Y') }}</span>
                    </v-footer>
                </v-main>
            </v-app>

            <!-- loader -->
            <div v-if="showLoader" class="wask_loader bg_half_transparent">
                <moon-loader color="red"></moon-loader>
            </div>

            <!-- snackbar -->
            <v-snackbar
                top
                :timeout="snackbarDuration"
                :color="snackbarColor"
                v-model="showSnackbar"
            >
                @{{ snackbarMessage }}
            </v-snackbar>

            <!-- dialog confirm -->
            <v-dialog v-show="showDialog" v-model="showDialog" absolute max-width="450px">
                <v-card>
                    <v-card-title>
                        <div class="headline">
                            <v-icon v-if="dialogIcon">@{{ dialogIcon }}</v-icon> 
                            @{{ dialogTitle }}
                        </div>
                    </v-card-title>
                    <v-card-text>@{{ dialogMessage }}</v-card-text>
                    <v-card-actions v-if="dialogType == 'confirm'">
                        <v-spacer></v-spacer>
                        <v-btn color="grey darken-1" text @click.native="dialogCancel">Cancel</v-btn>
                        <v-btn color="blue darken-1" text @click.native="dialogOk">Ok</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <!-- the progress bar -->
            <vue-progress-bar></vue-progress-bar>
        </template>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/manifest.js') }}"></script>
    <script src="{{ asset('js/vendor.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
