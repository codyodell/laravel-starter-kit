<template>
    <div class="page_wrap_vue pa-3">
        <h2>HOME PAGE</h2>
        <p>I am located at <kbd>resources/js/admin/dashboard/Home.vue</kbd></p>
        <p>single page routes for admin can be found at <kbd>resources/js/admin/router.js</kbd></p>
    </div>
</template>

<script>
    export default {
        mounted() {

            const self = this;

            self.$store.commit('setBreadcrumbs',[
                {
                    label: 'Dashboard',
                    name:''
                }
            ]);
        }
    }
</script>
