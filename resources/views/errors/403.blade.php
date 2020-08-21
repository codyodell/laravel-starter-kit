@php
$page_title = '$page_title';
$page_subtitle = 'Resource Forbidden';
@endphp
@extends('layouts.front')
@section('title', $page_title . ': ' . $page_subtitle)
@section('content')
@include('partials.header')
@component('components.page-content')
<v-carousel dark height="500" hide-delimiter-background hide-delimiters :show-arrows="false">
  <v-carousel-item>
    <v-sheet height="100%" align="center" justify="center" style="font-size: 1.75em;">
      <h1>
        <v-icon left color="grey">mdi-alert-box</v-icon>
        {{ $page_title }}
      </h1>
      <p>{{ $page_subtitle }}</p>
    </v-sheet>
  </v-carousel-item>
</v-carousel>
@endcomponent
@endsection
