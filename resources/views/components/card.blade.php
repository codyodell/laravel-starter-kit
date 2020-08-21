<v-card data-component="blade[card]" {{ $attributes }}>
  @unless(empty($title))
  <v-card-title>
    @unless(empty($icon))
    <v-icon left>{{ $icon }}</v-icon>
    @endunless
    {{ $title }}
  </v-card-title>
  @endunless
  <v-card-text>
    {{ $slot }}
  </v-card-text>
  @isset($footer)
  <v-card-actions>
    {{ $footer }}
  </v-card-actions>
  @endisset
</v-card>
