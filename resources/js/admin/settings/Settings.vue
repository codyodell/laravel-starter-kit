<template>
  <section :data-compontent="slug">
    <v-card class="mx-auto">
      <v-toolbar flat>
        <v-toolbar-title>
          <v-icon left>mdi-cog</v-icon>
          {{ page_name }}
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon>
          <v-icon>mdi-filter-variant</v-icon>
        </v-btn>
      </v-toolbar>
      <v-card-text>
        <p>
          I am located at
          <kbd>resources/js/admin/settings/Settings.vue</kbd>
        </p>
        <p>
          single page routes for admin can be found at
          <kbd>resources/js/admin/router.js</kbd>
        </p>
      </v-card-text>
    </v-card>
  </section>
</template>

<script>
export default {
  data: () => ({
    page_name: "Settings"
  }),
  mounted() {
    const self = this;

    self.$store.commit("setBreadcrumbs", [
      {
        label: "Settings",
        name: ""
      }
    ]);
  }
};
</script>
