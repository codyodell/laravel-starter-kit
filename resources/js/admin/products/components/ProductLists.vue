<template>
  <div class="component-wrap">
    <!-- Products -->
    <v-card>
      <div class="d-flex flex-column">
        <div class="flex-grow-1 pa-2">
          <v-text-field prepend-icon="search" label="Filter By Name" v-model="filters.name"></v-text-field>
        </div>
        <div class="flex-grow-1 pa-2">Show Only:</div>
        <div class="flex-grow-1 pa-2">
          <span v-for="(category, i) in filters.productCategoriesHolder" :key="i">
            <v-checkbox
              v-bind:label="category.name"
              v-model="filters.productCategoryId[category.id]"
            ></v-checkbox>
          </span>
        </div>
      </div>
    </v-card>

    <!-- categories table -->
    <v-data-table
      v-bind:headers="headers"
      :options.sync="pagination"
      :items="items"
      :server-items-length="totalItems"
      class="elevation-1"
    >
      <template v-slot:body="{items}">
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td>
              <v-btn @click="showDialog('product_show',item)" icon small>
                <v-icon class="blue--text">mdi-magnify</v-icon>
              </v-btn>
              <v-btn @click="trash(props.item)" icon small>
                <v-icon class="red--text">mdi-delete</v-icon>
              </v-btn>
            </td>
            <td>{{ item.name }}</td>
            <td>{{ item.category.name }}</td>
            <td>{{ item.brand.name }}</td>
            <td>{{ $appFormatters.formatDate(item.created_at) }}</td>
          </tr>
        </tbody>
      </template>
    </v-data-table>
    <!-- /groups table -->

    <!-- view file dialog -->
    <v-dialog
      v-model="dialogs.view.show"
      fullscreen
      :laze="false"
      transition="dialog-bottom-transition"
      :overlay="false"
    >
      <v-card>
        <v-toolbar class="primary">
          <v-btn icon @click.native="dialogs.view.show = false" dark>
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title class="white--text">{{dialogs.view.product.name}}</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <!--
            <v-btn dark text @click.native="downloadFile(dialogs.view.product)">
              Download
              <v-icon right dark>product_download</v-icon>
            </v-btn>
            -->
          </v-toolbar-items>
          <v-toolbar-items>
            <v-btn dark text @click.native="trash(dialogs.view.product)">
              Delete
              <v-icon right dark>delete</v-icon>
            </v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <div class="product_view_popup">
            <div class="product_view_popup_link">
              <!--<v-text-field text disabled :value="getFullUrl(dialogs.view.product)"></v-text-field>-->
            </div>
            <!--<img :src="getFullUrl(dialogs.view.product)" />-->
          </div>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  components: {},
  data() {
    return {
      headers: [
        { text: "Action", value: false, align: "left", sortable: false },
        { text: "Name", value: "name", align: "left", sortable: false },
        { text: "Category", value: "category", align: "left", sortable: false },
        { text: "Brand", value: "brand", align: "left", sortable: false },
        {
          text: "Date Created",
          value: "created_at",
          align: "left",
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
        productCategoryId: [],
        productCategoryHolder: []
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
  },
  watch: {
    "filters.productCategoryId": _.debounce(function(v) {
      let selected = [];

      _.each(v, (v, k) => {
        if (v) selected.push(k);
      });

      this.filters.selectedCategoryIds = selected.join(",");
    }, 500),
    "filters.selectedGCategoryIds"(v) {
      this.loadProducts(() => {});
    },
    "filters.name": _.debounce(function(v) {
      this.loadProducts(() => {});
    }, 500),
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
    loadProductCategories(cb) {
      const self = this;

      let params = {
        paginate: "no"
      };

      axios
        .get("/admin/product-categories", { params: params })
        .then(function(response) {
          self.filters.productCategoriesHolder = response.data.data;
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
        console.info("/admin/products");
        console.log(response);
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
</style>
