<v-navigation-drawer app left v-model="drawer">
  <v-sheet>
    <v-list-item>
      <v-list-item-action>
        <v-icon color="grey">mdi-storefront</v-icon>
      </v-list-item-action>
      <v-list-item-content>
        <v-list-item-title>
          {{ config('app.name') }}
        </v-list-item-title>
        <v-list-item-subtitle>
          <small>Everything you Need</small>
          {{ config('app.description') }}
        </v-list-item-subtitle>
      </v-list-item-content>
    </v-list-item>
  </v-sheet>
  @unless(empty($nav))
  <v-list dense>
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
    {{-- <v-divider></v-divider> --}}
    @endif
    @endforeach
  </v-list>
  @endunless
  <template v-slot:append>
    <v-sheet class="d-flex justify-space-between align-items-center pa-2">
      <v-btn color="grey darken-2" class="mx-1" icon small title="Send us an Email">
        <v-icon>mdi-email</v-icon>
      </v-btn>
      <v-btn color="grey darken-2" class="mx-1" icon small title="Reddit">
        <v-icon>mdi-reddit</v-icon>
      </v-btn>
      <v-btn color="grey darken-2" class="mx-1" icon small title="Follow us on Twitter">
        <v-icon>mdi-twitter</v-icon>
      </v-btn>
      <v-btn color="grey darken-2" class="mx-1" icon small title="LinkedIn">
        <v-icon>mdi-linkedin</v-icon>
      </v-btn>
      <v-btn color="grey darken-2" class="mx-1" icon small title="GitHub">
        <v-icon>mdi-github-circle</v-icon>
      </v-btn>
      <v-btn color="grey darken-2" class="mx-1" icon small title="Codepen.io">
        <v-icon>mdi-codepen</v-icon>
      </v-btn>
    </v-sheet>
  </template>
</v-navigation-drawer>
