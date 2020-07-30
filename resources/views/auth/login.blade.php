@extends('layouts.front')

@section('content')
<v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
        <v-col cols="12" sm="8" md="4">
            <v-form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <v-card max-width="344" class="mx-auto elevation-12">
                    <v-toolbar color="grey darken-4" dark flat>
                        <v-toolbar-title>Login</v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    <v-card-text>
                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                            <v-text-field
                                          label="Username"
                                          name="email"
                                          prepend-icon="mdi-account"
                                          type="email"
                                          value="{{ old('email') }}"
                                          autofocus
                                          required></v-text-field>
                            @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="{{ $errors->has('email') ? ' has-error' : '' }}">
                            <v-text-field
                                          id="password"
                                          label="Password"
                                          name="password"
                                          prepend-icon="mdi-lock"
                                          type="password"
                                          required></v-text-field>
                            @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div>
                            <v-checkbox
                                        name="remember"
                                        label="Remember Me"
                                        {{ old('remember') ? 'checked' : '' }}></v-checkbox>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary">Login</v-btn>
                    </v-card-actions>
                </v-card>
                <v-sheet flat class="pa-4 text-center">
                    <a href="{{ route('password.request') }}">
                        Forgot Your Password?
                    </a>
                </v-sheet>
            </v-form>
        </v-col>
    </v-row>
</v-container>
@endsection
@section('footer_scripts')
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
{{--<script src="{{ asset('js/front.js') }}"></script>--}}
@endsection
