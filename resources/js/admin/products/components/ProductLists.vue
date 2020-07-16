<template>
   <div class="component-wrap">
      <v-card flat>
         <v-card-title>
            {{ title }}
            <v-spacer></v-spacer>
            <v-btn icon title="Show Filters" color="grey">
               <v-icon>filter_alt</v-icon>
            </v-btn>
            <v-btn
               icon
               :to="{ name: 'product.add', data: { id: 1 } }"
               title="Add a Product"
               color="success"
            >
               <v-icon>add</v-icon>
            </v-btn>
         </v-card-title>
         <v-spacer></v-spacer>
         <v-card-text>
            <!--
      <v-btn small text color="grey">
         <v-icon left>cancel</v-icon>Cancel
      </v-btn>
            -->
            <!-- products table -->
            <v-data-table
               :headers="headers"
               :items="items"
               :options.sync="pagination"
               :server-items-length="totalItems"
            >
               <template slot="top">
                  <v-form>
                     <v-subheader>Filters</v-subheader>
                     <v-toolbar pa-1>
                        <v-toolbar-items>
                           <v-text-field v-model="filters.name" label="Name"></v-text-field>
                           <v-text-field v-model="filters.asin" label="ASIN #"></v-text-field>
                           <v-select
                              multiple
                              label="Categories"
                              :items="categories"
                              v-model="filters.categories"
                           ></v-select>
                           <v-btn small right color="success">
                              Apply Filters
                              <v-icon right>arrow_right</v-icon>
                           </v-btn>
                        </v-toolbar-items>
                     </v-toolbar>
                  </v-form>
               </template>
               <!--<template slot="body">-->
               <template slot="items" slot-scope="props">
                  <td>
                     <h4>
                        <a
                           @click="showDialog('product_details', props.item)"
                           title="View product details"
                        >{{ props.item.name }}</a>
                     </h4>
                  </td>
                  <td>
                     <v-chip
                        small
                        outlined
                        v-for="category in props.item.categories"
                        :key="category.id"
                     >{{ category.name }}</v-chip>
                  </td>
                  <td>
                     <v-chip small>{{ props.item.brand_id }}</v-chip>
                  </td>
                  <td>
                     <timeago :datetime="props.item.created_at"></timeago>
                     <span>
                        by
                        <router-link :to="{ name: 'users.view' }">{{ props.item.created_by }}</router-link>
                     </span>
                  </td>
                  <td class="text-right">
                     <v-btn
                        icon
                        color="grey"
                        title="Edit this product"
                        :to="{ name: 'product.edit', data: { id: props.item.id }}"
                     >
                        <v-icon>edit</v-icon>
                     </v-btn>
                     <!--
                     <v-btn
                        @click="trash(props.item)"
                        title="Delete this product"
                        color="error"
                        icon
                     >
                        <v-icon>delete</v-icon>
                     </v-btn>
                     -->
                  </td>
               </template>
            </v-data-table>
         </v-card-text>
      </v-card>

      <!-- view product dialog -->
      <v-dialog :laze="false" v-model="dialogs.view.show" transition="dialog-bottom-transition">
         <v-card flat>
            <v-card-title class="white--text primary darken-4">{{ dialogs.view.product.name }}</v-card-title>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn dark @click.native="dialogs.view.show = false" title="Close">
                  <v-icon>delete</v-icon>
               </v-btn>
            </v-card-actions>
         </v-card>
      </v-dialog>

      <v-dialog :laze="false" v-model="dialogs.edit.show" transition="dialog-bottom-transition">
         <v-card>
            <v-card-title class="white--text primary darken-4">{{ dialogs.edit.product.name }}</v-card-title>
            <v-card-actions>
               <v-spacer></v-spacer>
               <v-btn dark @click.native="dialogs.edit.show = false" title="Close">
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
      title: "Mange Products",
      loading: true,
      items: [],
      categories: [],
      categories_selected: [],
      totalItems: 0,
      pagination: { rowsPerPage: 10 },
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
               value: "categories.id",
               sortable: false
            },
            { text: "Brand", value: "brand_id" },
            { text: "Created", value: "created" },
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
      filters: {
         handler: resp => console.log(resp),
         deep: true
      }
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
                  name: self.filters.name,
                  categories: self.categories_selected.join(","),
                  page: self.pagination.page,
                  per_page: self.pagination.rowsPerPage
               }
            })
            .then(function(resp) {
               self.items = resp.data.data.data;
               self.totalItems = resp.data.data.total;
               self.pagination.totalItems = resp.data.data.total;
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
tbody > tr > td {
   vertical-align: baseline;
   padding: 0.25rem;
   white-space: nowrap;
}
</style>
