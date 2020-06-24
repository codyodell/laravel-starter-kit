<template>
  <div class="component-wrap">
    <v-tabs color="primary" v-model="active">
      <v-tab key="product.lists" href="#product.lists" ripple>Products</v-tab>
      <v-tab key="product.categories" href="#product.categories" ripple>Categories</v-tab>
      <v-tab key="product.brands" href="#product.brands" ripple>Brands</v-tab>
      <v-tab-item value="product.lists">
        <v-container>
          <v-card-text>
            <!-- Products -->
            <v-toolbar dense>
              <div class="d-flex flex-column">
                <div class="flex-grow-1 pa-2">
                  <v-text-field prepend-icon="search" label="Filter By Name" v-model="filters.name"></v-text-field>
                </div>
                <div class="flex-grow-1 pa-2">Show Only:</div>
                <div class="flex-grow-1 pa-2">
                  <span v-for="(category, i) in filters.categoriesHolder" :key="i">
                    <v-checkbox
                      v-bind:label="category.name"
                      v-model="filters.categoryId[category.id]"
                    ></v-checkbox>
                  </span>
                </div>
              </div>
            </v-toolbar>
            <!-- categories table -->
            <v-data-table
              v-bind:headers="headers"
              :options.sync="pagination"
              :items="items"
              :server-items-length="totalItems"
              class="elevation-1"
              :disable-filtering="true"
              :disable-pagination="!totalItems"
            >
              <template slot="items" slot-scope="props">
                <tbody>
                  <tr v-for="item in props.items" :key="item.id">
                    <td>
                      <strong>
                        <a @click="showDialog('product_details', item)">
                          {{ item.name }}
                        </a>
                      </strong>
                    </td>
                    <td>
                      <v-btn
                        v-for="category in props.item.categories"
                        :key="category.id"
                        small
                        outlined
                      >{{ category.name }}</v-btn>
                    </td>
                    <td>
                      <v-btn small outlined>{{ props.item.brand_id }}</v-btn>
                    </td>
                    <td>{{ $appFormatters.formatDate(props.item.created_at) }}</td>
                    <td align="right">
                      <v-btn @click="trash(props.item)" icon small>
                        <v-icon class="red--text">delete</v-icon>
                      </v-btn>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-data-table>
            <!-- /products table -->
          </v-card-text>
        </v-container>
      </v-tab-item>
      <v-tab-item value="product.categories">
        <v-container>
          <category-lists></category-lists>
        </v-container>
      </v-tab-item>
      <v-tab-item value="product.brands">
        <v-container>
          <brand-lists></brand-lists>
        </v-container>
      </v-tab-item>
    </v-tabs>

    <!-- view product dialog -->
    <v-dialog
      fullscreen
      :laze="false"
      v-model="dialogs.view.show"
      transition="dialog-bottom-transition"
      :overlay="false"
    >
      <v-card>
        <v-toolbar class="primary">
          <v-btn icon @click.native="dialogs.view.show = false" dark>
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>{{dialogs.view.product.name}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn dark text @click.native="trash(dialogs.view.product)">
              Delete
              <v-icon right dark>delete</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <p>Test</p>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import CategoryLists from "./CategoryLists.vue";
import BrandLists from "./BrandLists.vue";

export default {
  components: {
    CategoryLists,
    BrandLists
  },
  data() {
    return {
      active: "product.lists",
      headers: [
        { text: "Name", value: "name", align: "left", sortable: false },
        {
          text: "Category",
          value: "categories",
          align: "left",
          sortable: false
        },
        { text: "Brand", value: "brand_id", align: "left", sortable: false },
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
        selectedCategoryIds: "",
        categoryId: [],
        categoryHolder: []
      },

      dialogs: {
        view: {
          product: {},
          show: false
        }
      }
    };
  },
  mounted() {
    console.log("pages.products.components.ProductLists.vue");
    const self = this;
    self.$eventBus.$on(["PRODUCT_DELETED"], function() {
      self.loadProducts(() => {});
    });
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

              // maybe the action took place from view product
              // lets close it.
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
    loadCategories(cb) {
      const self = this;

      let params = {
        paginate: "no"
      };

      axios
        .get("/admin/categories", { params: params })
        .then(function(response) {
          console.info("Categories");
          console.log(response.data.data);
          self.filters.categoriesHolder = response.data.data;
          cb();
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

      axios.get("/admin/products", { params: params }).then(function(response) {
        self.items = response.data.data.data;
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
  min-width: 500px;
  text-align: center;
}
.finder_wrap {
  padding: 0 1.25em;
}
</style>
