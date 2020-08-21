<template>
  <section :data-component="slug">
    <v-form v-model="valid" ref="brandFormEdit" lazy-validation>
      <v-card flat>
        @method("PUT")
        <v-container grid-list-md>
          <v-layout row wrap>
            <v-flex xs12>
              <div class="body-2 white--text">{{ page_name }}</div>
            </v-flex>
            <v-flex xs12>
              <v-text-field dark label="Name" v-model="name" :rules="nameRules"></v-text-field>
            </v-flex>
            <v-flex xs12>
              <v-btn @click="save()" :disabled="!valid" color="primary" dark>Update</v-btn>
            </v-flex>
          </v-layout>
        </v-container>
      </v-card>
    </v-form>
  </section>
</template>

<script>
export default {
  props: {
    propBrandId: {
      required: true
    }
  },
  data: () => ({
    page_name: "Edit Brand",
    valid: false,
    isLoading: false,
    name: "",
    nameRules: [v => !!v || "Name is required"]
  }),
  mounted() {
    console.log("pages.products.components.BrandEdit.vue");

    const self = this;
  },
  watch: {
    propBrandId(v) {
      if (v) this.loadBrand(() => {});
    }
  },
  methods: {
    save() {
      const self = this;

      let payload = {
        name: self.name
      };

      self.isLoading = true;

      axios
        .put("/admin/brand/" + self.propBrandId, payload)
        .then(function(response) {
          self.$store.commit("showSnackbar", {
            message: response.data.message,
            color: "success",
            duration: 3000
          });

          self.isLoading = false;
          self.$eventBus.$emit("CATEGORY_UPDATED");
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
    loadBrand(cb) {
      const self = this;

      axios.get("/admin/brands/" + self.propBrandId).then(function(response) {
        let Brand = response.data.data;
        self.name = Brand.name;
        cb();
      });
    }
  }
};
</script>
