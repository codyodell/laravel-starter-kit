@extends('layouts.front')
@section('title', 'Login')
@section('content')
<v-row fill-height align-center justify-center>
  <v-col cols="12" sm="12" xs="12">
    <v-form method="POST" action="{{ route('login') }}" id="frmLogin">
      {{ csrf_field() }}
      <v-card max-width="360" class="mx-auto card--transparent" :loading="false" tile flat>
        <v-toolbar flat tile>
          <v-toolbar-title>Login</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-text-field id="username" label="Username" class="{{ $errors->has('email') ? ' has-error' : null }}" name="email" prepend-icon-inner="mdi-account" type="email" value="{{ old('email') }}" autofocus required></v-text-field>
          {{-- <v-alert :v-show="$errors->has('email')" text tile type=" danger">{{ $errors->first('email') }}</v-alert> --}}
          <v-text-field id="password" label="Password" class="{{ $errors->has('email') ? ' has-error' : null }}" name="password" prepend-icon-inner="mdi-lock" text type="password" required></v-text-field>

          {{-- <v-alert :v-show="$errors->has('password')" text tile type="danger">{{ $errors->first('password') }}</v-alert> --}}
        </v-card-text>
        <v-card-actions>
          <v-checkbox name="remember" label="Remember Me" {{ old('remember') ? 'checked' : null }}></v-checkbox>
          <v-spacer></v-spacer>
          <v-btn type="submit" :loading="loading" color="grey darken-2" tile>
            Login
            <v-icon>mdi-chevron-right</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
      <v-btn text small href="{{ route('password.request') }}">
        Forgot Your Password?
      </v-btn>
    </v-form>
  </v-col>
  <v-col cols="7" sm="12" xs="12">

  </v-col>
</v-row>
@endsection
