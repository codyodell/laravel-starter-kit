<template>
  <v-container fluid data-component="{!! page_slug !!}">
    <h1>{{ page_name }}</h1>
  </v-container>
</template>

<script>
export default {
   data: () => ({
      page_name: 'Login',
      username: "",
      password: "",
   }),
   computed: {
      page_slug () {
         return this.page_name.split(' ').join('-').toLowerCase()
      }
   }
}
</script>

<style lang="sass" scoped>
[data-component]
  background-color: rgba(0,0,0,0.33)
</style>
