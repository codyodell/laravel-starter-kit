@extends('layouts.front')
@section('title', 'Home')
@section('content')
<x-page-content>
  <v-card title="Filters" class="mx-auto overflow-hidden" height="400" width="344">
    <v-app-bar color="grey lighten-4" dark prominent>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>My files</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-magnify</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-filter</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-dots-vertical</v-icon>
      </v-btn>
    </v-app-bar>
    <p>The navigation drawer will appear from the bottom on smaller size screens.</p>
  </v-card>
</x-page-content>
@endsection
