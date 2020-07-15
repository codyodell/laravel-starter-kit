<template>
   <div class="component-wrap">
      <v-sheet>
         <v-card flat>
            <v-card-title>
               {{ title }}
               <v-spacer></v-spacer>
               <v-btn icon title="Filter Results">
                  <v-icon>filter_alt</v-icon>
               </v-btn>
               <v-btn icon :to="{ name: 'product.add' }" title="Add a Product">
                  <v-icon>plus-circle</v-icon>
               </v-btn>
            </v-card-title>
         </v-card>

         <v-form>
            <v-card>
               <v-card-title>
                  <v-icon left>filters_alt</v-icon>Filters
               </v-card-title>

               <v-row justify="space-around">
                  <v-col cols="7" md="12" sm="12">
                     <v-text-field v-model="filter_name" label="Name"></v-text-field>
                  </v-col>
                  <v-col cols="2" md="6" sm="6">
                     <v-text-field v-model="filter_asin" label="ASIN #"></v-text-field>
                  </v-col>
                  <v-col cols="3" md="6" sm="6">
                     <v-select
                        multiple
                        label="Categories"
                        v-model="filter_categories"
                        :items="categories"
                     ></v-select>
                  </v-col>
                  <v-col cols="12">
                     <v-btn small color="grey">Cancel</v-btn>
                     <v-btn small color="success">
                        Apply Filters
                        <v-icon right>arrow_right</v-icon>
                     </v-btn>
                  </v-col>
               </v-row>
            </v-card>
         </v-form>

         <!-- products table -->
         <v-data-table
            :headers="headers"
            :items="items"
            :options.sync="pagination"
            :server-items-length="totalItems"
            class="elevation-1"
         >
            <template v-slot:body="{items}">
               <tr v-for="item in items" :key="item.id">
                  <td>
                     <v-btn
                        text
                        large
                        @click="showDialog('product_details', item)"
                        :label="item.name"
                     ></v-btn>
                  </td>
                  <td></td>
                  <td>
                     <v-chip
                        v-for="category in item.categories"
                        :key="category.name"
                     >{{ item.brand_id }}</v-chip>
                  </td>
                  <td>
                     <v-btn @click="trash(item)" color="red" icon small>
                        <v-icon>delete</v-icon>
                     </v-btn>
                  </td>
               </tr>
            </template>
         </v-data-table>
      </v-sheet>

      <!-- view product dialog -->
      <v-dialog :laze="false" v-model="dialogs.view.show" transition="dialog-bottom-transition">
         <v-card flat>
            <v-card-title class="white--text orange darken-4">{{ dialogs.view.product.name }}</v-card-title>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn dark small @click.native="dialogs.view.show = false" title="Close">
                  <v-icon aria-hidden="true">delete</v-icon>
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>

      <v-dialog :laze="false" v-model="dialogs.edit.show" transition="dialog-bottom-transition">
         <v-card>
            <v-card-title class="white--text orange darken-4">{{ dialogs.edit.product.name }}</v-card-title>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn dark fab small @click.native="dialogs.edit.show = false" title="Close">
                  <v-icon>delete</v-icon>
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>
   </div>
</template>

<script>
import ProductAdd from "./ProductAdd.vue";
import ProductEdit from "./ProductEdit.vue";

export default {
   components: {
      ProductAdd,
      ProductEdit
   },
   data: () => ({
      title: "Products",
      loading: true,
      items: [],
      categories: [],
      categories_selected: [],
      totalItems: 0,
      pagination: {
         rowsPerPage: 10
      },
      filter_name: "",
      filter_asin: "",
      filter_categories: [],
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
   }),
   computed: {
      headers() {
         return [
            {
               text: "Name",
               value: "name",
               sortable: true,
               filter: filter_name
            },
            {
               text: "Categories",
               value: "categories.id",
               filter: filter_categories
            },
            { text: "Brand", value: "brand_id" },
            { text: "Date Created", value: "created_at" },
            { text: null, value: "controls" }
         ];
      }
   },
   mounted() {
      const self = this;

      self.$store.commit("setBreadcrumbs", [
         { label: "Products", to: { name: "product.lists" } }
      ]);

      self.loadProducts(() => {});
      self.loadCategories(() => {});

      self.$eventBus.$on(
         ["PRODUCT_ADDED", "PRODUCT_MODIFIED", "PRODUCT_DELETED"],
         () => self.loadProducts(() => {})
      );
   },
   watch: {
      "pagination.page": function() {
         this.loadProducts(() => {});
      },
      "pagination.rowsPerPage": function() {
         this.loadProducts(() => {});
      },
      filter_categories: _.debounce(function(resp) {
         console.log(resp);
         // this.loadProducts(() => {});
      }, 700)
   },
   methods: {
      showDialog(dialog, data) {
         const self = this;
         switch (dialog) {
            case "product_details":
               self.dialogs.view.product = data;
               setTimeout(() => {
                  self.dialogs.view.show = true;
               }, 500);
               break;
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
                  .then(function(resp) {
                     self.$store.commit("showSnackbar", {
                        message: resp.data.message,
                        color: "success",
                        duration: 3000
                     });

                     self.$eventBus.$emit("PRODUCT_DELETED");
                     // maybe the action took place from view product lets close it.
                     self.dialogs.view.show = false;
                  })
                  .catch(function(error) {
                     if (error.resp) {
                        self.$store.commit("showSnackbar", {
                           message: error.resp.data.message,
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
         axios
            .get("/admin/products", {
               params: {
                  name: self.filter_name,
                  categories: self.categories_selected.join(","),
                  page: self.pagination.page,
                  per_page: self.pagination.rowsPerPage
               }
            })
            .then(function(resp) {
               self.totalItems = resp.data.data.total;
               self.pagination.totalItems = resp.data.data.total;
               self.items = resp.data.data.data;
               resp.data.data.data.forEach(function(row) {
                  row.categories.forEach(function(category) {
                     console.info(category.name + ": " + category.id);
                  });
               });
               (cb || Function)();
            });
      },
      loadCategories(cb, params) {
         const self = this;
         params = params || { paginate: "no" };
         axios
            .get("/admin/categories", { params: params })
            .then(function(resp) {
               let items = resp.data.data;
               console.log(items instanceof Array);
               items.forEach(function(category, i) {
                  self.categories.push({
                     id: category.id,
                     name: category.name
                  });
               });
               (cb || Function)();
            });
      },
      getProductCategories(row) {
         return row.name;
      }
   }
};
/*loadResource(url, method, data, callback) {
         callback = callback || Function;
         data = data | [];
         let params = { params: data };
         const request = axios.call(method.toLowerCase(), url, method, params);

         switch (method.toUpperCase()) {
            case "GET":
               break;
            case "POST":
               break;
            case "PUT":
               break;
            case "DELETE":
               break;
         }
         callback();
      }*/
</script>

<style scoped>
.product_view_popup {
   min-width: 30rem;
}
</style>
