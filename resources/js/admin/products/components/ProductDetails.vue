<template>
  <div class="component-wrap">
    <h1>{{ name }}</h1>
  </div>
</template>

<script>
export default {
  data: () => ({
    page_name: "",
    valid: false,
    loading: false,
    name: "",
    description: "",
    price: 0.0,
    price_prefix: "$",
    attributes: {},
    created_by: "",
    created_at: "",
    updated_at: "",
  }),
  mounted() {
    const self = this;
  },
};
</script>
