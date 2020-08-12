<!DOCTYPE html>
@php

$user = Auth::user();

$config = [
'locale' => str_replace('_', '-', app()->getLocale()),
'name' => config('app.name'),
'url' => config('app.url'),
'description' => config('app.description'),
];

@endphp
<html lang="{!! $config['locale']; !!}">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name') }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script type="application/javascript">
    window.config = @json($config);

  </script>
  <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Mono|Material+Icons&display=swap">
  <link href="{{ mix('css/admin.css') }}">
</head>

<body>
  <div id="admin">
    <template>
      <v-app id="inspire">
        <v-navigation-drawer app left v-model="showDrawer" :clipped="$vuetify.breakpoint.lgAndUp">
          <v-list dense>
            @foreach($nav as $n)
            @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
            <v-list-item :to="{name: '{{$n->routeName}}'}" :exact="false">
              <v-list-item-action>
                <v-icon>{{$n->icon}}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{$n->label}}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
            @else
            <v-divider></v-divider>
            @endif
            @endforeach
            <v-list-item @click="clickLogout('{{ route('logout') }}', '{{ url('/') }}')">
              <v-list-item-action>
                <v-icon>mdi-logout-variant</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Logout</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
        </v-navigation-drawer>

        <v-app-bar app :clipped="$vuetify.breakpoint.lgAndUp">
          <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
          <v-toolbar-title>{{ config('app.name') }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark icon large v-bind="attrs" v-on="on" title="Logged in as {!! $user->name !!}">
                <v-avatar size="72px" color="grey lighten-1" item>
                  @auth
                  <v-img src="{!! $user->photo_url !!}" alt="Logged in as {!! $user->name !!}" />
                  @else
                  <v-icon>mdi-account</v-icon>
                  @endauth
                </v-avatar>
              </v-btn>
            </template>

            <v-list>
              <v-list-item title="View Profile" :to="{name: 'user.view', params: {id: {{ Auth::id() }} }}">
                <v-list-item-action>
                  <v-icon>mdi-account</v-icon>
                </v-list-item-action>
                <v-list-item-title>
                  Logged in as <strong>{{ $user->name }}</strong>
                </v-list-item-title>
              </v-list-item>
              <v-list-item @click="">
                <v-list-item-action>
                  <v-icon>mdi-gear</v-icon>
                </v-list-item-action>
                <v-list-item-title>Settings</v-list-item-title>
              </v-list-item>
              <v-list-item @click="clickLogout('{{ route('logout') }}', '{{ url('/') }}')">
                <v-list-item-action>
                  <v-icon>mdi-logout-variant</v-icon>
                </v-list-item-action>
                <v-list-item-title>Logout</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-menu>
        </v-app-bar>

        <v-content>
          <div>
            <v-breadcrumbs :items="getBreadcrumbs">
              <template v-slot:item="props">
                <v-breadcrumbs-item :to="props.item.to" exact :key="props.item.label" :disabled="props.item.disabled">
                  <template v-slot:divider>
                    <v-icon>mdi-forward</v-icon>
                  </template>
                  @{{ props.item.label }}
                </v-breadcrumbs-item>
              </template>
            </v-breadcrumbs>
          </div>
          <transition name="fade">
            <router-view></router-view>
          </transition>
        </v-content>
        <v-footer app>
          <v-row>
            <v-col cols="4" sm="12" class="text-sm-center">
              <v-btn icon small>
                <v-icon>mdi-facebook</v-icon>
              </v-btn>
              <v-btn icon small>
                <v-icon>mdi-twitter</v-icon>
              </v-btn>
              <v-btn icon small>
                <v-icon>mdi-github</v-icon>
              </v-btn>
            </v-col>
            <v-col cols="4" sm="6" xs="12" class="text-center">
              <v-btn small>
                <v-icon left>md-home</v-icon>Home
              </v-btn>
            </v-col>
            <v-col cols="4" sm="6" xs="12" class="text-right text-sm-center">
              <span>&copy; {{ date('Y') }}</span>
            </v-col>
          </v-row>
        </v-footer>
      </v-app>

      <!-- loader -->
      <div v-if="showLoader" class="wask_loader bg_half_transparent">
        <moon-loader color="grey lighten-2"></moon-loader>
      </div>

      <!-- snackbar -->
      <v-snackbar :timeout="snackbarDuration" :color="snackbarColor" top v-model="showSnackbar">
        @{{ snackbarMessage }}
      </v-snackbar>

      <!-- dialog confirm -->
      <v-dialog v-show="showDialog" v-model="showDialog" absolute max-width="450px">
        <v-card>
          <v-card-title>
            <div class="headline">
              <v-icon v-if="dialogIcon">@{{dialogIcon}}</v-icon> @{{ dialogTitle }}
            </div>
          </v-card-title>
          <v-card-text>@{{ dialogMessage }}</v-card-text>
          <v-card-actions v-if="dialogType=='confirm'">
            <v-spacer></v-spacer>
            <v-btn color="grey darken-1" text @click.native="dialogCancel">Cancel</v-btn>
            <v-btn color="primary darken-1" @click.native="dialogOk">Ok</v-btn>
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
