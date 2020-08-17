<v-navigation-drawer app left v-model="showDrawer" :clipped="$vuetify.breakpoint.lgAndUp">
  @isset($nav)
  <v-list dense>
    @foreach($nav as $n)
    @if($n->navType==\App\Components\Core\Menu\MenuItem::$NAV_TYPE_NAV && $n->visible)
    <v-list-item :to="{name: '{{ $n->routeName }}'}" :exact="false">
      <v-list-item-action>
        <v-icon>{{$n->icon}}</v-icon>
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
</v-navigation-drawer>
