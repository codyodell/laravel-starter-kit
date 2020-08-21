@extends('layouts.front')
@section('title', 'Register')
@section('content')
@component('components.page-content')
<v-form method="POST" action="{{ route('register') }}">
  <v-container fill-height align-center justify-center>
    {{ csrf_field() }}
    <v-card width="425" class="mx-auto" outlined tile>
      <v-card-title>Register</v-card-title>
      <v-card-subtitle>Sign up for an account using the form below</v-card-subtitle>
      <v-card-text>
        <v-text-field label="Name" id="name" class="{{ $errors->has('name') ? ' has-error' : null }}" type="text" name="name" value="{{ old('name') }}" required autofocus></v-text-field>
        <v-alert v-show="{{ $errors->has('name') }}" dark icon="error">{{ $errors->first('name') }}</v-alert>

        <v-text-field label="E-Mail Address" id="email" class="{{ $errors->has('email') ? ' has-error' : null }}" type="email" name="email" value="{{ old('email') }}" required></v-text-field>
        <v-alert v-show="{{ $errors->has('email') }}" dark icon="error">{{ $errors->first('email') }}</v-alert>

        <v-text-field label="Password" id="password" class="{{ $errors->has('password') ? ' has-error' : null }}" type="password" name="password" required></v-text-field>
        <v-alert v-show="{{ $errors->has('password') }}" dark icon="error">{{ $errors->first('password') }}</v-alert>

        <v-text-field label="Confirm Password" id="password-confirm" type="password" name="password_confirmation" required></v-text-field>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn type="submit" :loading="loading" color="primary">
          Continue
          <v-icon>mdi-chevron-right</v-icon>
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</v-form>
@endsection
