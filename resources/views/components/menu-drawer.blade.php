<v-navigation-drawer {{ $attributes }}>{{-- app left fixed v-model="drawer" :clipped="$vuetify.breakpoint.mdAndUp" --}}
  @slot('header')
  <v-list-item>
    <v-list-item-action>
      <v-icon>mdi-storefront</v-icon>
    </v-list-item-action>
    <v-list-item-content>
      <v-list-item-title class="title">
        {{ config('app.name') }}
      </v-list-item-title>
      <v-list-item-subtitle>
        {{ config('app.description') }}
      </v-list-item-subtitle>
    </v-list-item-content>
  </v-list-item>
  <v-divider></v-divider>
  @endslot
  @slot('body')
  @unless(empty($nav))
  <v-list dense nav>
    @foreach($nav as $n)
    @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
    <v-list-item :to="{name: '{{ $n->routeName }}'}" :exact="false">
      <v-list-item-action>
        <v-icon>{{ $n->icon }}</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          {{ $n->label }}
        </v-list-item-title>
      </v-list-item-content>
    </v-list-item>
    @else
    <v-divider></v-divider>
    @endif
    @endforeach
  </v-list>
  @endunless
  empty( @endslot)
  @slot('footer')
  <template v-slot:append>
    <v-divider></v-divider>
    <v-btn icon small color="grey darken-3">
      <v-icon>mdi-email</v-icon>
    </v-btn>
    <v-btn icon small color="grey darken-3">
      <v-icon>mdi-reddit</v-icon>
    </v-btn>
    <v-btn icon small color="grey darken-3">
      <v-icon>mdi-twitter</v-icon>
    </v-btn>
    <v-btn icon small color="grey darken-3">
      <v-icon>mdi-github</v-icon>
    </v-btn>
    <v-btn icon small color="grey darken-3">
      <v-icon>mdi-codepen</v-icon>
    </v-btn>
  </template>
  @endslot
</v-navigation-drawer>
