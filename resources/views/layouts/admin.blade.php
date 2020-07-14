<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,900|Roboto+Mono|Material+Icons" rel="stylesheet">
    <script type="application/javascript">
        var LSK_APP = {};
        LSK_APP.APP_URL = '{{ env('APP_URL') }}';
    </script>
</head>
<body>
<div id="admin">

    <template>
        <v-app id="inspire">
            <v-navigation-drawer
                v-model="drawer"
                app
                clipped
                left
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
                <v-list>
                    <v-list-item>
                        <v-list-item-action>
                            <v-menu offset-x>
                                <v-btn slot="activator" color="primary" dark>
                                    <v-avatar size="72px" dark>
                                        <img src="" alt="Profile Photo" />
                                    </v-avatar>
                                </v-btn>
                                <v-list>
                                    <v-list-tile @click="clickLogout('{{route('logout')}}','{{url('/')}}')">
                                        <v-list-tile-title>Logout</v-list-tile-title>
                                    </v-list-tile>
                                </v-list>
                            </v-menu>
                        </v-list-item-action>
                    </v-list-item>
                </v-list>
            </v-app-bar>
            <v-main>
                <v-container fluid>
                    <v-breadcrumbs :items="getBreadcrumbs">
                        <template v-slot:item="props">
                            <v-breadcrumbs-item 
                                :to="props.item.to" 
                                exact
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
                    <transition name="fade">
                        <router-view></router-view>
                    </transition>
                </v-container>
                <v-footer app fixed>
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
            :timeout="snackbarDuration"
            :color="snackbarColor"
            top
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
