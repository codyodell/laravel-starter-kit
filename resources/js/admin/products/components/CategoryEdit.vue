<template>
   <v-container fluid class="component-wrap">
      <v-form v-model="valid" ref="categoryFormEdit" lazy-validation>
         <v-card>
            <v-card-title>
               <v-icon>edit</v-icon>
               <span class="headline">Edit Category</span>
            </v-card-title>
            <v-card-text>
               <v-row>
                  <v-col cols="12">
                     <v-text-field dark label="Name" v-model="name" :rules="nameRules"></v-text-field>
                  </v-col>
                  <v-col cols="12">
                     <v-textarea
                        dark
                        label="Description"
                        v-model="description"
                        :rules="descriptionRules"
                     ></v-textarea>
                  </v-col>
                  <v-col cols="12">
                     <v-btn @click="save()" :disabled="!valid" color="primary" large dark>Update</v-btn>
                  </v-col>
               </v-row>
            </v-card-text>
         </v-card>
      </v-form>
   </v-container>
</template>

<script>
export default {
   props: {
      propCategoryId: {
         required: true
      }
   },
   data() {
      return {
         valid: false,
         isLoading: false,
         name: "",
         nameRules: [v => !!v || "Name is required"],
         description: "",
         descriptionRules: [v => !!v || "Description is required"]
      };
   },
   mounted() {
      console.info("pages.products.components.CategoryEdit.vue");

      const self = this;
   },
   watch: {
      propCategoryId(v) {
         if (v) this.loadCategory(() => {});
      }
   },
   methods: {
      save() {
         const self = this;

         let payload = {
            name: self.name,
            description: self.description
         };

         self.isLoading = true;

         axios
            .put("/admin/categories/" + self.propCategoryId, payload)
            .then(function(response) {
               self.$store.commit("showSnackbar", {
                  message: response.data.message,
                  color: "success",
                  duration: 3000
               });

               self.isLoading = false;
               self.$eventBus.$emit("CATEGORY_UPDATED");
            })
            .catch(function(error) {
               self.isLoading = false;
               if (error.response) {
                  self.$store.commit("showSnackbar", {
                     message: error.response.data.message,
                     color: "error",
                     duration: 3000
                  });
               } else if (error.request) {
                  console.log(error.request);
               } else {
                  console.log("Error", error.message);
               }
            });
      },
      loadCategory(cb) {
         const self = this;

         axios
            .get("/admin/categories/" + self.propCategoryId)
            .then(function(response) {
               let category = response.data.data;
               self.name = category.name;
               self.description = category.description;
               cb();
            });
      }
   }
};
</script>
