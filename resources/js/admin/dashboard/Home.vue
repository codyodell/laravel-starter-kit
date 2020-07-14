<template>
   <div class="page_wrap_vue pa-3">
      <v-card flat>
         <v-card-title>Homepage</v-card-title>
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
   </div>
</template>

<script>
export default {
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
