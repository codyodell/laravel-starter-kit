<template>
   <v-sheet class="component-wrap">
      <v-toolbar dense>
         <v-toolbar-title>{{ title }}</v-toolbar-title>
         <v-spacer></v-spacer>
         <v-btn icon fab>
            <v-icon>filters-alt</v-icon>
         </v-btn>
         <v-btn icon fab :to="{ name: 'product.add' }" title="Add a Product">
            <v-icon>plus-circle</v-icon>
         </v-btn>
      </v-toolbar>
      <v-expansion-panels>
         <v-expansion-panel>
            <v-expansion-panel-header>
               <v-icon>filters_alt</v-icon>Filters
            </v-expansion-panel-header>
            <v-expansion-panel-content>
               <v-form>
                  <v-row justify="space-around">
                     <v-col cols="12">
                        <v-text-field v-model="filters.name" label="Name"></v-text-field>
                     </v-col>
                     <v-col cols="6" md="6" sm="12">
                        <v-text-field v-model="filters.asin" label="ASIN #"></v-text-field>
                     </v-col>
                     <v-col cols="6" md="6" sm="12">
                        <v-select
                           label="Categories"
                           v-model="filters.category"
                           :items="filters.categories"
                        ></v-select>
                     </v-col>
                     <v-col cols="12">
                        <v-btn small color="grey">Cancel</v-btn>
                        <v-btn small color="primary">
                           Apply Filters
                           <v-icon right>arrow_right</v-icon>
                        </v-btn>
                     </v-col>
                  </v-row>
               </v-form>
            </v-expansion-panel-content>
         </v-expansion-panel>
      </v-expansion-panels>

      <!-- products table -->
      <v-data-table
         v-bind:headers="headers"
         :items="items"
         :options.sync="pagination"
         :server-items-length="totalItems"
      >
         <tr slot="items" v-for="item in items" :key="item.id">
            <td>
               <v-btn text large @click="showDialog('product_details', item)">{{ item.name }}</v-btn>
            </td>
            <td>
               <v-chip-group v-if="!!item.categories.length">
                  <template v-for="category in item.categories">
                     <v-chip
                        small
                        outlined
                        color="grey"
                        :key="category.id"
                        v-if="!!category.name.length"
                     >{{ category.name }}</v-chip>
                  </template>
               </v-chip-group>
            </td>
            <td>
               <v-chip dark v-if="item.brand_id">
                  <span>{{ item.brand_id }}</span>
               </v-chip>
            </td>
            <td>
               <time>{{ item.created_at }}</time>
            </td>
            <td class="text-right">
               <v-btn @click="trash(item)" color="red" icon small>
                  <v-icon>delete</v-icon>
               </v-btn>
            </td>
         </tr>
      </v-data-table>
      <!-- /products table -->

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
   </v-sheet>
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
         title: "Products",
         loading: true,
         headers: [
            {
               text: "Name",
               value: "name",
               align: "start",
               sortable: false
            },
            {
               text: "Categories",
               value: "categories",
               sortable: false
            },
            {
               text: "Brand",
               value: "brand",
               sortable: false
            },
            {
               text: "Date Created",
               value: "created_at",
               sortable: false
            },
            {
               text: " ",
               value: false,
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
            asin: "",
            category: "", // Model
            categories: [],
            categories_selected: []
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
      self.$store.commit("setBreadcrumbs", [
         { label: "Products", to: { name: "product.lists" } }
      ]);
      self.$eventBus.$on(
         ["PRODUCT_ADDED", "PRODUCT_MODIFIED", "PRODUCT_DELETED"],
         () => self.loadProducts(() => {})
      );

      self.loadProducts(() => {});
      self.loadCategories(() => {});
   },
   watch: {
      "pagination.page": function() {
         this.loadProducts(() => {});
      },
      "pagination.rowsPerPage": function() {
         this.loadProducts(() => {});
      },
      "filters.categories": _.debounce(function() {
         this.loadProducts(() => {});
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
         let params = {
            name: self.filters.name,
            categories: self.filters.categories_selected.join(","),
            page: self.pagination.page,
            per_page: self.pagination.rowsPerPage
         };

         axios.get("/admin/products", { params: params }).then(function(resp) {
            self.items = resp.data.data.data;
            self.totalItems = resp.data.data.total;
            self.pagination.totalItems = resp.data.data.total;
            (cb || Function)();
         });
      },
      loadCategories(cb, params) {
         params = params || { paginate: "no" };
         const self = this;
         axios.get("/admin/categories", { params: params }).then(resp => {
            let items = resp.data.data.data;
            let hasItems = typeof items === "Object" && items.length === 0;
            if (!hasItems) return false;
            console.info("Response");
            console.log(typeof items, items);
            self.filter.categories = items.map(category => {
               console.log(category);
               return !!category.name.length ? category.name : false;
            });
            (cb || Function)();
         });
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
