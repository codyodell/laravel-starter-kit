@extends('layouts.front')
@section('title', 'Home')
@section('content')
<x-page-content>
  <v-card outlined flat class="mx-auto overflow-hidden" max-width="344">
    <v-app-bar color="primary lighten-4" prominent>
      <v-toolbar-title>Data</v-toolbar-title>
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
    <v-card-text>
      <p>The navigation drawer will appear from the bottom on smaller size screens.</p>
    </v-card-text>
  </v-card>
</x-page-content>
@endsection
