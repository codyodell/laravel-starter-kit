<template>
   <v-container class="component-wrap" fluid>
      <v-form>
         <v-card flat>
            <v-card-title>
               <v-icon left>filter</v-icon>
               <h5>Filters</h5>
               <v-spacer></v-spacer>
               <v-btn :to="{name: 'product.add'}" rounded>
                  <v-icon>add</v-icon>
               </v-btn>
            </v-card-title>
            <v-card-text>
               <v-container>
                  <v-row>
                     <v-col cols="4" sm="4" xs="12">
                        <v-text-field v-model="filters.name" label="Name"></v-text-field>
                     </v-col>
                     <v-col cols="4" sm="4" xs="12">
                        <v-text-field v-model="filters.ASIN" label="ASIN #"></v-text-field>
                     </v-col>
                     <v-col cols="4" sm="4" xs="12">
                        <v-select
                           label="Category"
                           v-model="filters.category"
                           :items="filters.categories"
                        ></v-select>
                     </v-col>
                  </v-row>
               </v-container>
            </v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn color="blue darken-1" large>Submit</v-btn>
            </v-card-actions>
         </v-card>
      </v-form>
      <!-- products table -->
      <v-data-table
         v-bind:headers="headers"
         :items="items"
         :options.sync="pagination"
         :server-items-length="totalItems"
         :disable-pagination="totalItems === 0"
         class="elevation-4"
      >
         <tbody>
            <tr v-for="item in items" :key="item.id">
               <td>
                  <strong @click="showDialog('product_details', item)">{{ item.name }}</strong>
               </td>
               <td>
                  {{ debug(item.categories) }}
                  <template v-for="category in item.categories">
                     <v-chip small outlined color="grey" :key="category.id">{{ category.name }}</v-chip>
                  </template>
               </td>
               <td>
                  <v-btn small outlined>{{ item.brand_id }}</v-btn>
               </td>
               <td>
                  <time>{{ $appFormatters.formatDate(strtotime(item.created_at)) }}</time>
               </td>
               <td class="align-right">
                  <v-btn @click="trash(item)" color="red" text icon small>
                     <v-icon>delete</v-icon>
                  </v-btn>
               </td>
            </tr>
         </tbody>
      </v-data-table>
      <!-- /products table -->

      <!-- view product dialog -->
      <v-dialog
         fullscreen
         :laze="false"
         v-model="dialogs.view.show"
         transition="dialog-bottom-transition"
         :overlay="false"
      >
         <v-card>
            <v-card-title class="white--text orange darken-4">
               {{ dialogs.view.product.name }}
               <v-spacer></v-spacer>
               <v-btn dark fab small @click.native="dialogs.view.show = false" title="Close">
                  <v-icon>delete</v-icon>
               </v-btn>
            </v-card-title>
            <v-card-text>
               <p>Test</p>
            </v-card-text>
         </v-card>
      </v-dialog>

      <v-dialog
         fullscreen
         :laze="false"
         v-model="dialogs.edit.show"
         transition="dialog-bottom-transition"
         :overlay="false"
      >
         <v-card>
            <v-card-title class="white--text orange darken-4">
               {{ dialogs.edit.product.name }}
               <v-spacer></v-spacer>
               <v-btn dark fab small @click.native="dialogs.edit.show = false" title="Close">
                  <v-icon>delete</v-icon>
               </v-btn>
            </v-card-title>
            <v-card-text>
               <p>Test</p>
            </v-card-text>
         </v-card>
      </v-dialog>
   </v-container>
</template>

<script>
import ProductAdd from "./ProductAdd.vue";
import ProductEdit from "./ProductEdit.vue";

export default {
   components: {
      ProductAdd,
      ProductEdit
   },
   data() {
      return {
         active: "product.lists",
         headers: [
            {
               text: "Name",
               value: "name",
               align: "left",
               sortable: false
            },
            {
               text: "Category",
               value: "categories",
               align: "left",
               sortable: false
            },
            {
               text: "Brand",
               value: "brand",
               align: "left",
               sortable: false
            },
            {
               text: "Date Created",
               value: "created_at",
               align: "left",
               sortable: false
            },
            {
               text: " ",
               value: false,
               align: "right",
               sortable: false
            }
         ],
         items: [],
         totalItems: 0,
         pagination: {
            rowsPerPage: 10
         },

         filters: {
            name: "",
            ASIN: "",
            selectedCategoryIds: "",
            category: [],
            categories: []
         },

         dialogs: {
            view: {
               product: {},
               show: false
            },
            edit: {
               product: {},
               show: false
            }
         }
      };
   },
   mounted() {
      const self = this;
      self.loadCategories(() => {});
      self.$eventBus.$on(
         ["PRODUCT_ADDED", "PRODUCT_MODIFIED", "PRODUCT_DELETED"],
         function() {
            self.loadCategories(() => {});
            self.loadProducts(() => {});
         }
      );
   },
   watch: {
      "pagination.page": function() {
         this.loadProducts(() => {});
      },
      "pagination.rowsPerPage": function() {
         this.loadProducts(() => {});
      }
   },
   methods: {
      showDialog(dialog, data) {
         const self = this;
         switch (dialog) {
            case "product_show":
               self.dialogs.view.product = data;
               setTimeout(() => {
                  self.dialogs.view.show = true;
               }, 500);
               break;
         }
      },
      trash(product) {
         const self = this;

         self.$store.commit("showDialog", {
            type: "confirm",
            title: "Confirm Deletion",
            message: "Are you sure you want to delete this product?",
            okCb: () => {
               axios
                  .delete("/admin/products/" + product.id)
                  .then(function(response) {
                     self.$store.commit("showSnackbar", {
                        message: response.data.message,
                        color: "success",
                        duration: 3000
                     });

                     self.$eventBus.$emit("PRODUCT_DELETED");
                     // maybe the action took place from view product lets close it.
                     self.dialogs.view.show = false;
                  })
                  .catch(function(error) {
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
            cancelCb: () => {
               console.log("CANCEL");
            }
         });
      },
      loadProducts(cb) {
         const self = this;

         let params = {
            name: self.filters.name,
            categories: self.filters.selectedCategoryIds,
            page: self.pagination.page,
            per_page: self.pagination.rowsPerPage
         };

         axios
            .get("/admin/products", { params: params })
            .then(function(response) {
               self.items = response.data.data.data;
               self.totalItems = response.data.data.total;
               self.pagination.totalItems = response.data.data.total;
               (cb || Function)();
            });
      },
      loadCategories(cb, params) {
         const self = this;
         if (!params) {
            params = {
               name: self.filters.name,
               ASIN: self.filters.ASIN,
               categories: self.filters.selectedCategoryIds,
               page: self.pagination.page,
               per_page: self.pagination.rowsPerPage
            };
         }
         axios
            .get("/admin/categories", { params: params })
            .then(function(response) {
               self.filters.nCategoryID = 0;
               self.filters.categories = [];
               self.filters.selectedCategoryIds = [];
               response.data.data.data.entries(category => {
                  console.log(`Categories: ${category}`);
                  self.filters.categories[category.id] = category.name;
               });
               self.totalItems = response.data.data.total;
               self.pagination.totalItems = response.data.data.total;
               (cb || Function)();
            });
      }
   }
};
</script>

<style scoped>
.product_view_popup {
   min-width: 30rem;
   text-align: center;
}
.finder_wrap {
   padding: 0 1.25em;
}
</style>
