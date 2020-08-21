<template>
  <section :data-component="slug">
    <h1>{{ page_name }}</h1>
  </section>
</template>

<script>
export default {
  data: () => ({
    page_name: "Product Details",
    valid: false,
    loading: false,
    name: "",
    description: "",
    price: 0.0,
    price_prefix: "$",
    attributes: {},
    created_by: "",
    created_at: "",
    updated_at: ""
  }),
  mounted() {
    const self = this;
  }
};
</script>
