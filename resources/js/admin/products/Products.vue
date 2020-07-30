<template>
  <div class="page_wrap_vue pa-3">
    <v-tabs v-model="active" color="accent">
      <v-tab key="product.lists" href="#product.lists" ripple>Products</v-tab>
      <v-tab key="product.categories" href="#product.categories" ripple>Categories</v-tab>
      <v-tab key="product.brnands" href="#product.brands" ripple>Brands</v-tab>
      <v-tab-item value="product.lists">
        <product-lists />
      </v-tab-item>
      <v-tab-item value="product.categories">
        <category-lists />
      </v-tab-item>
      <v-tab-item value="product.brands">
        <brand-lists />
      </v-tab-item>
    </v-tabs>
  </div>
</template>
<script>
import ProductLists from './components/ProductLists.vue'
import CategoryLists from './components/CategoryLists.vue'
import BrandLists from './components/BrandLists.vue'

export default {
   components: {
      ProductLists,
      CategoryLists,
      BrandLists,
   },
   data: () => ({
      active: '',
   }),
   mounted () {
      console.info('Admin > Products')
      const self = this
   },
}
</script>
