<v-card {{ $attributes->merge(['outlined']) }}>
  <v-card-title class="text-h1">{{ $title }}</v-card-title>
  <v-card-text>
    {{ $slot }}
  </v-card-text>
</v-card>
