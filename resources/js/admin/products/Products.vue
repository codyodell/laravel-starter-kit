<template>
  <div class="page_wrap_vue">
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </div>
</template>

<script>
import ProductLists from "./components/ProductLists.vue";
import CategoryLists from "./components/CategoryLists.vue";

export default {
  components: {
    ProductLists,
    CategoryLists
  },
  data() {
    return {
      active: ""
    };
  },
  mounted() {
    console.info("pages.Products.vue");

    const self = this;

    self.$store.commit("setBreadcrumbs", [
      {
        label: "Products",
        name: ""
      }
    ]);
  },
  watch: {
    active(v) {
      console.log("active tab: " + v);
    }
  },
};
</script>
