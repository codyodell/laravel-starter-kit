<template>
  <div data-component="admin" class="page_wrap_vue">
    <h1>
      <v-icon>view_dashboard</v-icon>
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
  </div>
</template>

<script>
export default {
   data: () => ({
      page_name: "Admin Dashboard"
   }),
   mounted () {
      const self = this

      self.$store.commit("setBreadcrumbs", [
         {
            label: "Admin Dashboard",
            name: ""
         }
      ])
   }
};
</script>
