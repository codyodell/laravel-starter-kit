<template>
  <section :data-component="slug">
    <v-row>
      <!-- Left Column -->
      <v-col cols="9" md="8" sm="12">
        <!-- Page Header -->
        <h1 class="mt-2">{{ page_name }}</h1>

        <!-- Products Table -->
        <v-data-table
          :headers="headers"
          :items="items"
          :item-key="items.name"
          :options.sync="pagination"
          :server-items-length="totalItems"
          :loading="isLoadingProducts"
        >
          <template v-slot:item="{ item }">
            <tr>
              <td>
                <a
                  @click="showDialog('product_details', item.id)"
                  title="View product details"
                  class="text-h6"
                >{{ item.name }}</a>
              </td>
              <td>
                <v-chip-group>
                  <template v-for="category in item.categories">
                    <v-chip
                      small
                      color="primary"
                      :key="category.id"
                      @click="
                          $router.push({
                            name: 'category.lists',
                            params: { id: item.id }
                          })
                        "
                    >{{ category.name }}</v-chip>
                  </template>
                </v-chip-group>
              </td>
              <td>
                <v-chip
                  small
                  color="primary"
                  @click="
                      $router.push({
                        name: 'brand.edit',
                        params: { id: item.brand_id }
                      })
                    "
                >{{ item.brand.name }}</v-chip>
              </td>
              <td>
                <timeago :datetime="item.created_at"></timeago>
              </td>
              <td>
                <v-btn
                  text
                  small
                  @click="
                      $router.push({
                        name: 'users.view',
                        params: { id: item.created_by }
                      })
                    "
                >{{ item.created_by }}</v-btn>
              </td>
              <td class="text-right">
                <v-btn
                  tile
                  small
                  color="secondary"
                  @click="$router.push({name: 'product.edit', params: { id: item.id }})"
                  title="Edit this product"
                >
                  <v-icon left>mdi-pencil</v-icon>Edit
                </v-btn>
              </td>
            </tr>
          </template>
        </v-data-table>
      </v-col>
      <v-col cols="2" md="2" sm="3" xs="12" class="pl-2">
        <!-- Right Column: Search Filters -->
        <v-form ref="form" v-model="valid">
          <v-card flat role="search">
            <v-card-title>
              <v-icon left>filter_alt</v-icon>
              <span>Filters</span>
            </v-card-title>
            <v-card-text>
              <v-text-field
                filled
                rounded
                autofocus
                clearable
                full-width
                required
                v-model="filters.name"
                prepend-inner-icon="search"
                placeholder="Filter by Name, SKU or ASIN"
                :rules="[v => !!v || 'Search query is required']"
              ></v-text-field>
              <v-select
                required
                multiple
                rounded
                filled
                full-width
                placeholder="Categories"
                v-model="filters.categories"
                :items="categories"
                :loading="isLoadingCategories"
                :rules="[v => !!v || 'Category is required']"
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-btn small text color="grey darken-2" @click="clear">
                <v-icon left>mdi-close</v-icon>Cancel
              </v-btn>
              <v-spacer></v-spacer>
              <v-btn small color="success" :disabled="!valid" @click="submit">
                Apply Filters
                <v-icon right>mdi-arrow-right</v-icon>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-form>
      </v-col>
    </v-row>
    <!-- view product dialog -->
    <v-dialog :laze="false" v-model="dialogs.view.show" transition="dialog-bottom-transition">
      <v-card>
        <v-card-title>{{ dialogs.view.product.name }}</v-card-title>
        <v-card-text>
          <product-details></product-details>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn icon @click.native="dialogs.view.show = false" title="Close">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog :laze="false" v-model="dialogs.edit.show" transition="dialog-bottom-transition">
      <v-card outlined>
        <v-card-subtitle>Edit Product</v-card-subtitle>
        <v-card-title>{{ dialogs.edit.product.name }}</v-card-title>
        <v-card-text>
          <product-edit></product-edit>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn icon @click.native="dialogs.edit.show = false" title="Close Form">
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </section>
</template>

<script>
import ProductAdd from "./ProductAdd.vue";
import ProductEdit from "./ProductEdit.vue";
import ProductDetails from "./ProductDetails.vue";

export default {
  components: {
    ProductAdd,
    ProductEdit,
    ProductDetails
  },
  data: () => ({
    page_name: "Manage Products",
    action: "lists",
    valid: true,
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
    },
    nameRules: [
      v => !!v || "Name is required",
      v => (v && v.length <= 10) || "Name must be less than 10 characters"
    ],
    categoryRules: []
  }),
  computed: {
    headers() {
      const self = this;
      return [
        {
          text: "Name",
          value: "name",
          sortable: false,
          width: "200px",
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

    self.$store.commit("setBreadcrumbs", [{ label: "Products", name: "" }]);
    self.loadCategories(() => {});
    self.loadProducts(() => {});
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
    "filters.categories": function(test) {
      console.info(`Products -> Watch() -> Categories: ${test}`);
    }
  },
  methods: {
    submit() {
      let is_valid = this.$refs.form.validate();
      console.info(`Is valid? ${is_valid}`);
    },
    showDialog(dialog, data) {
      const self = this;
      switch (dialog) {
        case "product_view":
          self.dialogs.view.product = data;
          setTimeout(() => {
            self.dialogs.view.show = true;
          }, 1000);
          break;
        case "product_edit":
          self.dialogs.edit.product = data;
          setTimeout(() => {
            self.dialogs.edit.show = true;
          }, 1000);
          break;
        case "product_delete":
          self.dialogs.delete.product = data;
          setTimeout(() => {
            self.dialogs.delete.show = true;
          }, 1000);
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
          console.info("CANCEL");
        }
      });
    },
    loadProducts(cb) {
      const self = this;
      self.isLoadingProducts = true;
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
          self.isLoadingProducts = false;
          self.items = resp.data.data.data;
          console.info("loadProducts().then()");
          console.dir(self.items);
          self.totalItems = resp.data.data.total;
          self.pagination.totalItems = resp.data.data.total(cb || Function)();
        })
        .catch(function(error) {
          self.isLoadingProducts = false;
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
    loadCategories(cb, params) {
      params = params || { paginate: "no" };
      const self = this;
      self.isLoadingCategories = true;
      axios
        .get(`/admin/categories`, self.requestParams(params))
        .then(function(resp) {
          self.isLoadingCategories = false;
          const items = resp.data.data;
          console.info("loadCategories().then()");
          console.dir(items);
          self.categories = items.map(item => item.name)(cb || Function)();
        });
    },
    requestParams: params => ({ params: params })
  }
};
</script>

<style scoped>
.product_view_popup {
  min-width: 30rem;
}
</style>
