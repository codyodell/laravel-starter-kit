@extends('layouts.front')

@section('content')
@component('components.page-content')
<v-form method="POST" action="{{ route('password.request') }}">
  {{ csrf_field() }}
  <input type="hidden" name="token" value="{{ $token }}">
  <v-card>
    <v-card-title>Reset Password</v-card-title>
    <v-card-text>
      <input id="email" type="email" label="E-Mail Address" name="email" value="{{ $email or old('email') }}" class="{{ $errors->has('email') ? ' has-error' : null }}" required autofocus>
      <span v-show="$errors->has('email')">{{ $errors->first('email') }}</span>
      <input id="password" type="password" label="Password" name=" password" class="{{ $errors->has('password') ? 'has-error' : null }}" required>
      <span v-show="$errors->has('password')">{{ $errors->first('password') }}</span>
      <input id="password-confirm" type="password" label="Confirm Password" name="password_confirmation" class="{{ $errors->has('password_confirmation') ? 'has-error' : null }}" required>
      <span v-show="$errors->has('password_confirmation')">{{ $errors->first('password_confirmation') }}</span>
    </v-card-text>
    <v-card-actions>
      <button type="submit" color="primary">
        Reset Password
        <v-icon>mdi-chevron-right</v-icon>
      </button>
    </v-card-actions>
  </v-card>
</v-form>
@endcomponent
@endsection
