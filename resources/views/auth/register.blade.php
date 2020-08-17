@extends('layouts.front')
@section('title', 'Register')
@section('content')
@component('components.page-content')
<v-form class="form-horizontal" method="POST" action="{{ route('register') }}">
  {{ csrf_field() }}
  @component('components.card')
  @slot('title')
  Register
  @endslot

  <v-text-field label="Name" id="name" class="form-group{{ $errors->has('name') ? ' has-error' : '' }}" type="text" name="name" value="{{ old('name') }}" required autofocus></v-text-field>
  @if ($errors->has('name'))
  <v-alert dark icon="error">{{ $errors->first('name') }}</v-alert>
  @endif

  <v-text-field label="E-Mail Address" id="email" class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" type="email" name="email" value="{{ old('email') }}" required></v-text-field>
  @if ($errors->has('email'))
  <v-alert dark icon="error">{{ $errors->first('email') }}</v-alert>
  @endif

  <v-text-field label="Password" id="password" class="form-group{{ $errors->has('password') ? ' has-error' : '' }}" type="password" name="password" required></v-text-field>
  @if ($errors->has('password'))
  <v-alert dark icon="error">{{ $errors->first('password') }}</v-alert>
  @endif

  <v-text-field label="Confirm Password" id="password-confirm" type="password" name="password_confirmation" required></v-text-field>
  @slot('footer')
  <v-spacer></v-spacer>
  <v-btn type="submit" class="btn btn-primary">
    Register
    <v-icon right>mdi-arrow-right</v-icon>
  </v-btn>
  @endslot
  @endcomponent
</v-form>
@endsection
