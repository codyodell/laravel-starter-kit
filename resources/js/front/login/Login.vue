<template>
  <v-container fluid :data-component="slug">
    <h1>{{ page_name }}</h1>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    page_name: "Login",
    username: "",
    password: ""
  }),
  computed: {
    slug() {
      return $appFormatters.slug(this.page_name);
    }
  }
};
</script>

<style lang="scss" scoped>
[data-component] {
  background-color: rgba(0, 0, 0, 0.33);
}
</style>
