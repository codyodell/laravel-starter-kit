<template>
  <div class="page_wrap_vue pa-3">
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
import ProductLists from "./components/ProductLists.vue";
// import ProductCategoryLists from './components/ProductCategoryLists.vue';

export default {
  components: {
    ProductLists
  },
  data() {
    return {
      active: "products"
    };
  },
  mounted() {
    
    console.info("pages.FileManager.vue");

    const self = this;

    self.$store.commit("setBreadcrumbs", [{ 
      label: "Products", 
      name: "" 
    }]);
  }
};
</script>
