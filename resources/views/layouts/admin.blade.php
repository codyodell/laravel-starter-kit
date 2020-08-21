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
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{ config('app.description') }}">
  <meta name="author" content="{{ config('app.author') }}">
  <link rel="manifest" href="{{ asset('manifest.json') }}">
  @isset($config)
  <script type="application/javascript">
    window.config = @json($config);

  </script>
  @endisset
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900|Roboto+Mono">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
</head>

<body>
  <div id="admin">
    <template>
      <v-app>
        <v-navigation-drawer app left v-model="drawer" :clipped="$vuetify.breakpoint.lgAndUp">
          @isset($nav)
          <v-list dense nav>
            @foreach($nav as $n)
            @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
            <v-list-item :to="{name: '{{ $n->routeName }}'}" :exact="false">
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
            <v-list-item @click="clickLogout('{{ route('logout') }}', '{{ url('/') }}')">
              <v-list-item-action>
                <v-icon>mdi-logout</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>Logout</v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list>
          @endisset
        </v-navigation-drawer>

        <v-app-bar app :clipped="$vuetify.breakpoint.lgAndUp">
          <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
          <v-toolbar-title>{{ config('app.name') }}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-menu bottom left>
            <template v-slot:activator="{ on, attrs }">
              <v-btn dark icon large v-bind="attrs" v-on="on" @auth title="Logged in as {!! $user->name !!}" @endauth>
                <v-avatar size="32px" color="grey darken-1" item>
                  @auth
                  <v-img src="{!! $user->photo_url !!}" alt="Logged in as {!! $user->name !!}" aspect-ratio="1"></v-img>
                  @else
                  <v-icon>mdi-account-circle</v-icon>
                  @endauth
                </v-avatar>
              </v-btn>
            </template>
            <v-card>
              <v-list>
                <v-list-item>
                  <v-list-item-avatar>
                    <v-avatar size="32px" color="grey darken-2" item>
                      @auth
                      <v-img src="{!! $user->photo_url !!}" alt="Logged in as {!! $user->name !!}" aspect-ratio="1"></v-img>
                      @else
                      <v-icon>mdi-account</v-icon>
                      @endauth
                    </v-avatar>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title>{{ $user->name }}</v-list-item-title>
                    <v-list-item-subtitle>Logged In</v-list-item-subtitle>
                  </v-list-item-content>
                  <v-list-item-action>
                    <v-btn>
                      <v-icon>mdi-menu-right</v-icon>
                    </v-btn>
                  </v-list-item-action>
                </v-list-item>
              </v-list>
              <v-divider></v-divider>
              {{--
            <v-list>
                <v-list-item>
                <v-list-item-action>
                    <v-switch v-model="message" color="secondary darken-1"></v-switch>
                </v-list-item-action>
                <v-list-item-title>Enable messages</v-list-item-title>
                </v-list-item>
                <v-list-item>
                <v-list-item-action>
                    <v-switch v-model="hints" color="secondary"></v-switch>
                </v-list-item-action>
                <v-list-item-title>Enable hints</v-list-item-title>
                </v-list-item>
            </v-list>
            --}}
              <v-card-actions>
                <v-btn text @click="clickLogout('{{ route('logout') }}', '{{ url('/') }}')">Logout</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" :to="{name: 'user.view', params: {id: {{ Auth::id() }} }}">
                  Profile
                  <v-icon right>mdi-menu-right</v-icon>
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>
        </v-app-bar>
        <v-main>
          @include('partials.breadcrumbs')
          <v-container fluid fill-height justify-center align-center>
            <transition name="fade">
              <router-view></router-view>
            </transition>
          </v-container>
        </v-main>
        @include('partials.footer')
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
          <v-card-title class="headline">
            <v-icon v-show="dialogIcon" left>@{{ dialogIcon }}</v-icon>
            @{{ dialogTitle }}
          </v-card-title>
          <v-card-text>
            @{{ dialogMessage }}
          </v-card-text>
          <v-card-actions v-if="dialogType=='confirm'">
            <v-btn color="grey darken-1" text @click.native="dialogCancel">Cancel</v-btn>
            <v-spacer></v-spacer>
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
