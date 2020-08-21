@php

$app_name = $app_name ?? config('app.name');
$app_url = $app_url ?? config('app.url');
$app_icon = $app_icon ?? 'mdi-storefront';

@endphp
<v-app-bar app flat {{ $attributes }}>
  <v-app-bar-nav-icon @click.stop="toggleDrawer"></v-app-bar-nav-icon>
  @slot('title')
  <v-toolbar-title class="pa-0">
    <v-btn text large class="logo" title="{!! $app_name !!}" href="{!! $app_url !!}">
      <v-icon left>{{ $app_icon }}</v-icon>
      <span>{{ $app_name }}</span>
    </v-btn>
  </v-toolbar-title>
  @endslot
  <v-spacer></v-spacer>
  @slot('nav')
  @auth
  <v-btn small text href="{!! url('/admin') !!}">
    <v-icon left>mdi-view-dashboard-variant</v-icon>
    Dashboard
  </v-btn>
  @else
  <v-btn small text href="{!! route('login') !!}">
    <v-icon left>mdi-login-variant</v-icon>
    Login
  </v-btn>
  <v-btn small text href="{!! route('register') !!}">
    <v-icon left>mdi-account-circle</v-icon>
    Register
  </v-btn>
  @endauth
  @endslot
</v-app-bar>
