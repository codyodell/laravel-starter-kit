<template>
   <div class="component-wrap">
      <v-card>
         <v-form v-model="valid" ref="productFormEdit" lazy-validation>
            <v-container grid-list-md>
               <v-layout row wrap>
                  <v-flex xs12>
                     <div class="body-2 white--text">Product Details</div>
                  </v-flex>
                  <v-flex xs12>
                     <v-text-field dark label="Name" v-model="name" :rules="nameRules"></v-text-field>
                  </v-flex>
                  <v-flex xs12>
                     <v-textarea
                        dark
                        label="Description"
                        v-model="description"
                        :rules="descriptionRules"
                     ></v-textarea>
                  </v-flex>
                  <v-flex xs12>
                     <v-btn @click="save()" :disabled="!valid" color="primary" dark>Update</v-btn>
                  </v-flex>
               </v-layout>
            </v-container>
         </v-form>
      </v-card>
   </div>
</template>

<script>
export default {
   props: {
      propProductId: {
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
      console.info("pages.products.components.ProductEdit.vue");
      const self = this;
   },
   watch: {
      propProductId(v) {
         if (v) this.loadProduct(() => {});
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
            .put("/admin/products/" + self.propProductId, payload)
            .then(function(response) {
               self.$store.commit("showSnackbar", {
                  message: response.data.message,
                  color: "success",
                  duration: 3000
               });

               self.isLoading = false;
               self.$eventBus.$emit("PRODUCT_UPDATED");
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
      loadProduct(cb) {
         const self = this;

         axios
            .get("/admin/products/" + self.propProductId)
            .then(function(response) {
               let product = response.data.data;
               self.name = product.name;
               self.description = product.description;
               cb();
            });
      }
   }
};
</script>
