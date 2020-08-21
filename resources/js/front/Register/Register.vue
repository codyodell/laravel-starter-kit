<template>
  <v-container fluid :data-component="slug">
    <h1>{{ page_name }}</h1>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    page_name: "Register",
    username: "",
    password: ""
  }),
  mounted() {
    console.info("Login.vue -> Mounted");
  }
};
</script>

<style lang="sass" scoped>
[data-component]
  background-color: rgba(0, 0, 0, 0.33)
</style>
