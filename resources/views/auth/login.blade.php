@extends('layouts.front')
@section('title', 'Login')
@section('content')
<v-container fluid full-height>
  <v-row align="center" justify="center">
    <v-col cols="12" sm="8" md="4">
      <v-form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <v-card max-width="344" class="mx-auto mb-4" flat tile>
          <v-toolbar color="primary" dark flat tile>
            <v-toolbar-title>Login</v-toolbar-title>
            <v-spacer></v-spacer>
          </v-toolbar>
          <v-card-text>
            <v-text-field label="Username" class="{{ $errors->has('email') ? ' has-error' : '' }}" name="email" prepend-icon="mdi-account" type="email" value="{{ old('email') }}" autofocus required></v-text-field>
            @if ($errors->has('email'))
            <v-alert text tile type="danger">{{ $errors->first('email') }}</v-alert>
            </span>
            @endif
            <v-text-field id="password" class="{{ $errors->has('email') ? ' has-error' : '' }}" label="Password" name="password" prepend-icon="mdi-lock" text type="password" required></v-text-field>
            @if ($errors->has('password'))
            <v-alert text tile type="danger">{{ $errors->first('password') }}</v-alert>
            </span>
            @endif
          </v-card-text>
          <v-card-actions>
            <v-checkbox name="remember" label="Remember Me" {{ old('remember') ? 'checked' : '' }}></v-checkbox>
            <v-spacer></v-spacer>
            <v-btn type="submit" color="primary">
              Login
              <v-icon right>mdi-arrow-right</v-icon>
            </v-btn>
          </v-card-actions>
        </v-card>
        <v-flex align-items="start">
          <v-btn text small href="{{ route('password.request') }}">
            Forgot Your Password?
          </v-btn>
        </v-flex>
      </v-form>
    </v-col>
  </v-row>
</v-container>
@endsection
