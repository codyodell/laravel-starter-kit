<template>
  <section :data-component="slug">
    <h1>
      <v-icon left>mdi-view-dashboard</v-icon>
      {{ page_name }}
    </h1>
    <p>
      I am located at
      <kbd>resources/js/admin/dashboard/Admin.vue</kbd>
    </p>
    <p>
      single page routes for admin can be found at
      <kbd>resources/js/admin/router.js</kbd>
    </p>
  </section>
</template>

<script>
export default {
  data: () => ({
    page_name: "Admin Dashboard"
  }),
  mounted() {
    console.info("Admin.vue -> Mounted");
    const self = this;
    self.$store.commit("setBreadcrumbs", [
      {
        label: "Admin Dashboard",
        name: ""
      }
    ]);
  }
};
</script>
