<v-app-bar app flat>
  <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
  <v-toolbar-title class="pa-0">
    <v-btn tile text class="logo" title="{!! config('app.name') !!}" href="{!! url('/') !!}">
      <v-icon left class="grey">mdi-storefront</v-icon>{{ config('app.name') }}
    </v-btn>
  </v-toolbar-title>
  <v-spacer></v-spacer>
  @auth
  <v-btn text href="{{ url('/admin') }}">Dashboard</v-btn>
  @else
  <v-btn text href="{{ route('login') }}">Login</v-btn>
  <v-btn text href="{{ route('register') }}">Register</v-btn>
  @endauth
</v-app-bar>
