  <v-footer app inset>
    <v-row no-gutters>
      <v-col cols="sm">
        @unless(empty($nav))
        @foreach($nav as $n)
        @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
        <v-btn small text :to="{name: '{{ $n->routeName }}'}" :exact="false">
          <v-icon left color="grey">{{ $n->icon }}</v-icon>
          {{ $n->label }}
        </v-btn>
        @else
        {{-- <v-divider></v-divider> --}}
        @endif
        @endforeach
        @endunless
      </v-col>
      <v-col cols="sm" align="right" align-sm="center">
        <v-btn small icon class="mx-1">
          <v-icon color="grey">mdi-language-html5</v-icon>
        </v-btn>
        <v-btn small icon class="mx-1">
          <v-icon color="grey">mdi-language-css3</v-icon>
        </v-btn>
        <v-btn small icon class="mx-1">
          <v-icon color="grey">mdi-sass</v-icon>
        </v-btn>
        <v-icon color="grey darken-3" class="mx-2">mdi-circle-medium</v-icon>
        <v-btn small text class="ml-1 text__app-name" color="grey">
          <v-icon left color="grey darken-3">mdi-storefront</v-icon>{{ config('app.name') }}
        </v-btn>
      </v-col>
    </v-row>
  </v-footer>
