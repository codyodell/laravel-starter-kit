<template>
   <v-card class="mx-auto" style="margin-top: -4rem;">
      <v-toolbar flat>
         <v-icon left>settings</v-icon>
         <v-toolbar-title>Settings</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-btn icon @click="toggle">
            <v-icon>filters_alt</v-icon>
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
</template>

<script>
export default {
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
