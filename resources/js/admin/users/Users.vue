<template>
  <section :data-component="slug">
    <transition name="fade">
      <router-view></router-view>
    </transition>
  </section>
</template>

<script>
export default {
  data: () => ({
    active: ""
  })
};
</script>
