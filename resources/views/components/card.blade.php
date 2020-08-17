<v-card data-component="card">
  @isset($title)
  <v-card-title>{{ $title }}</v-card-title>
  @endisset
  <v-card-text>
    {{ $slot }}
  </v-card-text>
  @isset($footer)
  <v-card-actions>
    {{ $footer }}
  </v-card-actions>
  @endisset
</v-card>
