<template>
  <div class="component-wrap">
    <v-form ref="productFormEdit" v-model="valid" lazy-validation>
      <v-card>
        <v-card-title>Edit Product</v-card-title>
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="name" dark label="Name" :rules="nameRules" />
          </v-col>
          <v-col cols="12">
            <v-textarea v-model="description" dark label="Description" :rules="descriptionRules" />
          </v-col>
        </v-row>
        <v-card-actions>
          <v-btn :disabled="!valid" color="success" dark @click="save()">
            Update
            <v-icon>mdi-menu-right</v-icon>
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </div>
</template>

<script>
export default {
   props: {
      propProductId: {
         required: true,
      },
   },
   data: () => ({
      valid: false,
      isLoading: false,
      name: '',
      nameRules: [ v => !!v || 'Name is required' ],
      description: '',
      descriptionRules: [ v => !!v || 'Description is required' ],
   }),
   watch: {
      propProductId (v) {
         if (v) this.loadProduct(() => { })
      },
   },
   methods: {
      save () {
         const self = this
         self.isLoading = true
         axios
            .put(`/admin/products/${ self.propProductId }`, {
               name: self.name,
               description: self.description,
            })
            .then(function (response) {
               self.$store.commit('showSnackbar', {
                  message: response.data.message,
                  color: 'success',
                  duration: 3000,
               })

               self.isLoading = false
               self.$eventBus.$emit('PRODUCT_UPDATED')
            })
            .catch(function (error) {
               self.isLoading = false
               if (error.response) {
                  self.$store.commit('showSnackbar', {
                     message: error.response.data.message,
                     color: 'error',
                     duration: 3000,
                  })
               } else if (error.request) {
                  console.log(error.request)
               } else {
                  console.log('Error', error.message)
               }
            })
      },
      loadProduct (cb) {
         const self = this
         axios
            .get(`/admin/products/${ self.propProductId }`)
            .then(function (response) {
               const product = response.data.data
               self.name = product.name
               self.description = product.description
               cb()
            })
      },
   },
}
</script>
