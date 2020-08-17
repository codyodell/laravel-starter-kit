<v-app-bar app flat>
  <v-app-bar-nav-icon></v-app-bar-nav-icon>
  <v-toolbar-title class="pa-0">
    <v-btn text large class="logo" title="{{ app_name }}" href="{{ app_url }}">
      <v-icon left>mdi-storefront-outline</v-icon>
      <span>{{ app_name }}</span>
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
