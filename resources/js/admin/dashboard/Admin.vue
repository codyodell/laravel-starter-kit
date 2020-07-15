<template>
   <div class="page_wrap_vue">
      <h2>
         <v-icon>mdi-view-dashboard</v-icon>
         {{ page_name }}
      </h2>
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
   mounted() {
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
