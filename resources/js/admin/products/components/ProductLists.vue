<template>
   <div class="component-wrap">
      <!-- Page Header -->
      <v-container fluid>
         <v-row>
            <v-col cols="9" md="9" sm="12">
               <h1 class="mt-2">{{ title }}</h1>
               <v-btn-toggle v-model="action" tile group>
                  <v-btn :to="{ name: 'product.lists' }" title="View All">
                     <v-icon left>view_list</v-icon>View All
                  </v-btn>
                  <v-btn :to="{ name: 'product.add', params: { id: 1 } }" title="Add a Product">
                     <v-icon>add</v-icon>Add a Product
                  </v-btn>
               </v-btn-toggle>

               <!-- Products Table -->
               <v-data-table
                  :headers="headers"
                  :items="items"
                  :item-key="name"
                  :options.sync="pagination"
                  :server-items-length="totalItems"
                  :loading="isLoadingProducts"
               >
                  <!--<template slot="items" slot-scope="props">-->
                  <template v-slot:item="{ item }">
                     <tr>
                        <td>
                           <a
                              @click="showDialog('product_details', item.id)"
                              title="View product details"
                           >{{ item.name }}</a>
                        </td>
                        <td>
                           <v-chip-group>
                              <template v-for="category in item.categories">
                                 <v-chip small outlined :key="category.id">{{ category.name }}</v-chip>
                              </template>
                           </v-chip-group>
                        </td>
                        <td>
                           <v-chip small>{{ item.brand.name }}</v-chip>
                        </td>
                        <td>
                           <timeago :datetime="item.created_at"></timeago>
                        </td>
                        <td>
                           <router-link
                              :to="{ name: 'users.view', params: { id: item.created_by } }"
                           >{{ item.created_by }}</router-link>
                        </td>
                        <td class="text-right">
                           <v-btn
                              tile
                              :to="{ name: 'product.edit', data: { id: item.id }}"
                              title="Edit this product"
                           >
                              <v-icon>edit</v-icon>
                              <v-subheader>
                                 <v-icon left>pencil</v-icon>Edit
                              </v-subheader>
                           </v-btn>
                           <!--   
                           <v-btn
                              tile
                              color="error"
                              @click="trash(item)"
                              title="Delete this product"
                           >
                              <v-icon>delete</v-icon>
                           </v-btn>
                           -->
                        </td>
                     </tr>
                  </template>
               </v-data-table>
            </v-col>
            <v-col cols="3" md="2" sm="12">
               <!-- Search Filters -->
               <v-form ref="item_filters">
                  <v-card outlined>
                     <v-card-title>
                        <v-icon left>filter_alt</v-icon>Filters
                     </v-card-title>
                     <v-row>
                        <v-col cols="12">
                           <v-text-field
                              flat
                              autofocus
                              clearable
                              v-model="filters.name"
                              label="Name"
                           ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                           <v-text-field
                              flat
                              clearable
                              disabled
                              v-model="filters.asin"
                              label="ASIN #"
                           ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                           <v-select
                              multiple
                              flat
                              full-width
                              label="Categories"
                              v-model="filters.categories"
                              :items="categories"
                              :loading="isLoadingCategories"
                           ></v-select>
                        </v-col>
                     </v-row>
                     <v-card-actions>
                        <v-btn text color="grey darken-1">
                           <v-icon left>cancel</v-icon>Cancel
                        </v-btn>
                        <v-spacer></v-spacer>
                        <v-btn tile color="success">
                           Apply Filters
                           <v-icon right>arrow_right</v-icon>
                        </v-btn>
                     </v-card-actions>
                  </v-card>
               </v-form>
            </v-col>
         </v-row>
      </v-container>

      <!-- view product dialog -->
      <v-dialog :laze="false" v-model="dialogs.view.show" transition="dialog-bottom-transition">
         <v-card>
            <v-card-title>{{ dialogs.view.product.name }}</v-card-title>
            <v-card-text></v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn icon @click.native="dialogs.view.show = false" title="Close">
                  <v-icon>delete</v-icon>
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>

      <v-dialog :laze="false" v-model="dialogs.edit.show" transition="dialog-bottom-transition">
         <v-card outlined>
            <v-card-subtitle>Edit Product</v-card-subtitle>
            <v-card-title>{{ dialogs.edit.product.name }}</v-card-title>
            <v-card-text></v-card-text>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn icon @click.native="dialogs.edit.show = false" title="Close Form">
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
      title: "Manage Products",
      action: "lists",
      isLoadingProducts: false,
      isLoadingCategories: false,
      items: [],
      categories: [],
      categories_selected: [],
      totalItems: 0,
      pagination: {
         rowsPerPage: 10
      },
      filters: {
         name: "",
         asin: "",
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
   }),
   computed: {
      headers() {
         const self = this;
         return [
            {
               text: "Name",
               value: "name",
               sortable: false,
               filter: self.filters.name
            },
            {
               text: "Categories",
               value: "categories",
               sortable: false
            },
            { text: "Brand", value: "brand_id" },
            { text: "Created", value: "created_by" },
            { text: "", value: "controls" }
         ];
      },
      products() {
         const self = this;
      }
   },
   mounted() {
      const self = this;

      self.$store.commit("setBreadcrumbs", [
         { label: "Products", name: "product.lists" }
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
      } /* ,
      filters: {
         handler: resp => console.log(resp),
         deep: true
      }*/
   },
   methods: {
      showDialog(dialog, data) {
         const self = this;
         switch (dialog) {
            case "product_view":
               self.dialogs.view.product = data;
               setTimeout(() => {
                  self.dialogs.view.show = true;
               }, 500);
               break;
            case "product_edit":
               self.dialogs.edit.product = data;
               setTimeout(() => {
                  self.dialogs.edit.show = true;
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
            .get(
               "/admin/products",
               self.requestParams({
                  name: self.filters.name,
                  categories: self.categories_selected.join(","),
                  page: self.pagination.page,
                  per_page: self.pagination.rowsPerPage
               })
            )
            .then(function(resp) {
               self.items = resp.data.data.data;
               console.log("loadProducts().then()", self.items);
               self.totalItems = resp.data.data.total;
               self.pagination.totalItems = resp.data.data.total;
               (cb || Function)();
            });
      },
      loadCategories(cb, params) {
         const self = this;
         params = params || { paginate: "no" };
         axios
            .get("/admin/categories", self.requestParams(params))
            .then(function(resp) {
               const items = resp.data.data;
               console.log("loadProducts().then()", items);
               self.categories = items;
               /* items.forEach(function(category, i) {
                  self.categories.push({
                     id: category.id,
                     name: category.name
                  });
               });*/
               (cb || Function)();
            });
      },
      requestParams(params, defaults) {
         // defaults = typeof defaults === "Object" ? defaults : { ...defaults };
         // return !!params ? { params: params } : defaults;
         return { params: params };
      }
   }
};
/*
loadResource(url, method, data, callback) {
   callback = callback || Function;
   data = data | [];
   method = method || 'GET';
   let params = { params: data };
   const request = axios.call(method.toLowerCase(), url, method, params);

   switch (method.toUpperCase()) {
      case "GET":
         axios.get();
         break;
      case "POST":
         axios.post();
         break;
      case "PUT":
         break;
      case "DELETE":
         break;
   }
   (callback)();
}
*/
</script>

<style scoped>
.product_view_popup {
   min-width: 30rem;
}
tbody > tr > td {
   vertical-align: baseline;
   padding: 0.25rem;
   white-space: nowrap;
}
</style>
