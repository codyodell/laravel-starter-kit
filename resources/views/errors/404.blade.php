@extends('layouts.front')
@section('title', '404: Page not Found')
@section('content')
@include('partials.header')
@component('components.page-content')
<v-carousel dark height="500" hide-delimiter-background hide-delimiters :show-arrows="false">
  <v-carousel-item>
    <v-sheet height="100%" align="center" justify="center">
      <h1>
        <v-icon left color="grey">mdi-alert-box</v-icon>
        404
      </h1>
      <p>Page not Found</p>
    </v-sheet>
  </v-carousel-item>
</v-carousel>
@endcomponent
@endsection
