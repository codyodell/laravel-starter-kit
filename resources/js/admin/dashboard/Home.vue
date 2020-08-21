<template>
  <section :data-component="slug">
    <v-container>
      <v-card flat>
        <v-card-title>{{ page_name }}</v-card-title>
        <v-card-text>
          <p>
            I am located at
            <kbd>resources/js/admin/dashboard/Home.vue</kbd>
          </p>
          <p>
            single page routes for admin can be found at
            <kbd>resources/js/admin/router.js</kbd>
          </p>
        </v-card-text>
      </v-card>
    </v-container>
  </section>
</template>

<script>
export default {
  data: () => ({
    page_name: "Home"
  }),
  mounted() {
    const self = this;
    self.$store.commit("setBreadcrumbs", [
      {
        label: "Home",
        name: ""
      }
    ]);
  }
};
</script>
