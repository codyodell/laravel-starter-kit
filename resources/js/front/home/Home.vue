<template>
  <section :data-component="slug">
    <v-container fluid>
      <v-row fill-height align-center justify-center>
        <v-col>
          <v-main>
            <h1>{{ page_name }}</h1>
            <transition name="fade">
              <router-view></router-view>
            </transition>
          </v-main>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>
<script>
export default {
  data: () => ({
    page_name: "Home"
  })
};
</script>

<style lang="sass" scoped>
[data-component]
  background-color: rgba(0, 0, 0, 0.33)
</style>
