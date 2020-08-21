@extends('layouts.front')

@section('content')
@component('components.page-content')
<v-form method="POST" action="{{ route('password.email') }}">
  {{ csrf_field() }}
  <v-card flat tile>
    <v-card-title>Reset Password</v-card-title>
    <v-card-text>
      @if (session('status'))
      <v-alert type="success">{{ session('status') }}</v-alert>
      @endif
      <input id="email" type="email" class="{{ $errors->has('email') ? ' has-error' : null }}" label="E-Mail Address" name=" email" value="{{ old('email') }}" required>
      <v-alert :v-show="$errors->has('email')" type="error">{{ $errors->first('email') }}</v-alert>
    </v-card-text>
    <v-card-actions>
      <v-btn type="submit" :loading="loading" color="primary">
        Send Password Reset Link
        <v-icon>mdi-chevron-right</v-icon>
      </v-btn>
    </v-card-actions>
  </v-card>
</v-form>
@endcomponent
@endsection
