<template>
  <div class="component-wrap">
    <!-- search -->
    <v-card>
      <div class="d-flex flex-row">
        <div class="flex-grow-1">
          <v-text-field prepend-icon="search" label="Filter By Name" v-model="filters.name"></v-text-field>
        </div>
        <div class="flex-grow-1 text-right">
          <v-btn @click="showDialog('brand_add')" dark class="primary lighten-1">
            New Brand
            <v-icon right>add</v-icon>
          </v-btn>
        </div>
      </div>
    </v-card>
    <!-- /search -->

    <!-- brands table -->
    <v-data-table
      v-bind:headers="headers"
      :options.sync="pagination"
      :items="items"
      :server-items-length="totalItems"
      :disable-pagination="pagination.show"
      class="elevation-1"
    >
      <template slot="items">
        <tbody>
          <tr v-for="item in items" :key="item.id">
            <td>
              <strong>{{ item.name }}</strong>
            </td>
            <td class="text-center">
              <v-btn tag="span" rounded>{{ item.product_count }}</v-btn>
            </td>
            <td>{{ $appFormatters.formatDate(item.created_at) }}</td>
            <td align="right">
              <v-btn @click="showDialog('brand_edit', item)" icon small>
                <v-icon class="blue--text">edit</v-icon>
              </v-btn>
              <v-btn @click="trash(item)" icon small>
                <v-icon class="red--text">delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-data-table>

    <!-- add brand -->
    <v-dialog
      v-model="dialogs.add.show"
      fullscreen
      transition="dialog-bottom-transition"
      :overlay="false"
    >
      <v-card>
        <v-toolbar class="primary">
          <v-btn @click.native="dialogs.add.show = false" icon>
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Create New Brand</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn text @click.native="dialogs.add.show = false">Done</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <brand-add></brand-add>
        </v-card-text>
      </v-card>
    </v-dialog>

    <!-- edit product brand -->
    <v-dialog
      v-model="dialogs.edit.show"
      fullscreen
      :laze="false"
      transition="dialog-bottom-transition"
      :overlay="false"
    >
      <v-card>
        <v-toolbar class="primary">
          <v-btn icon @click.native="dialogs.edit.show = false">
            <v-icon>close</v-icon>
          </v-btn>
          <v-toolbar-title>Edit Brand</v-toolbar-title>
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn text @click.native="dialogs.edit.show = false">Done</v-btn>
          </v-toolbar-items>
        </v-toolbar>
        <v-card-text>
          <brand-edit :propBrandId="dialogs.edit.brand.id"></brand-edit>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import BrandAdd from "./BrandAdd.vue";
import BrandEdit from "./BrandEdit.vue";

export default {
  components: {
    BrandAdd,
    BrandEdit
  },
  data() {
    return {
      headers: [
        {
          text: "Name",
          value: "name",
          align: "left",
          sortable: false
        },
        {
          text: "Total Products",
          value: "product_count",
          align: "center",
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
        show: false,
        rowsPerPage: 10
      },

      filters: {
        name: ""
      },

      dialogs: {
        edit: {
          brand: {},
          show: false
        },
        add: {
          show: false
        }
      }
    };
  },
  mounted() {
    console.log("pages.products.components.BrandLists.vue");

    const self = this;

    self.$eventBus.$on(
      ["BRAND_ADDED", "BRAND_UPDATED", "BRAND_DELETED"],
      () => {
        self.loadBrands(() => {});
      }
    );
  },
  watch: {
    "filters.name": _.debounce(function(v) {
      this.loadBrands(() => {});
    }, 500),
    "pagination.page": function() {
      this.loadBrands(() => {});
    },
    "pagination.rowsPerPage": function() {
      this.loadBrands(() => {});
    }
  },
  methods: {
    trash(brand) {
      const self = this;

      self.$store.commit("showDialog", {
        type: "confirm",
        title: "Confirm Deletion",
        message: "Are you sure you want to delete this brand?",
        okCb: () => {
          axios
            .delete("/admin/brands/" + brand.id)
            .then(function(response) {
              self.$store.commit("showSnackbar", {
                message: response.data.message,
                color: "success",
                duration: 3000
              });

              self.$eventBus.$emit("BRAND_DELETED");
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
    showDialog(dialog, data) {
      const self = this;

      switch (dialog) {
        case "brand_edit":
          self.dialogs.edit.brand = data;
          setTimeout(() => {
            self.dialogs.edit.show = true;
          }, 500);
          break;
        case "brand_add":
          setTimeout(() => {
            self.dialogs.add.show = true;
          }, 500);
          break;
      }
    },
    loadBrands(cb) {
      const self = this;

      let params = {
        name: self.filters.name,
        page: self.pagination.page,
        per_page: self.pagination.rowsPerPage
      };

      axios.get("/admin/brands", { params: params }).then(function(response) {
        self.items = response.data.data.data;
        self.totalItems = response.data.data.total;
        self.pagination.totalItems = response.data.data.total;
        self.pagination.show = response.data.data.total > 0;
        (cb || Function)();
      });
    }
  }
};
</script>
