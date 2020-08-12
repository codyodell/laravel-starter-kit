@extends('layouts.front')
@section('content')
<template>
  <v-app id="inspire">
    <v-main>
      <v-app-bar app flat>
        <v-app-bar-nav-icon></v-app-bar-nav-icon>
        <v-toolbar-title class="pa-0">
          <v-btn text large class="logo" title="{{ config('app.name') }}" href="{{ url('/') }}">
            <v-icon left>mdi-storefront-outline</v-icon>
            <span>{{ config('app.name') }}</span>
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
        <v-row justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-sheet class="pa-4 text-center">
              <h4>Powered By</h4>
              <img src="{{ asset('img/logos/laravel.svg') }}" height="140px" alt="Laravel">
              <img src="{{ asset('img/logos/vuejs.svg') }}" height="140px" alt="Vue.js">
            </v-sheet>
          </v-col>
        </v-row>
      </v-container>
      <v-footer app class="text-center">
        <v-btn icon text>
          <v-icon>mdi-facebook</v-icon>
        </v-btn>
        <v-btn icon text>
          <v-icon>mdi-twitter</v-icon>
        </v-btn>
        <v-btn icon text>
          <v-icon>mdi-github</v-icon>
        </v-btn>
      </v-footer>
    </v-main>
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
