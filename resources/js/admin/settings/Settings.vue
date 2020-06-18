<template>
    <div class="page_wrap_vue pa-3">
        <h2>SETTINGS PAGE</h2>
        <p>I am located at <kbd>resources/js/admin/settings/Settings.vue</kbd></p>
        <p>single page routes for admin can be found at <kbd>resources/js/admin/router.js</kbd></p>
    </div>
</template>

<script>
    export default {
        mounted() {

            const self = this;

            self.$store.commit('setBreadcrumbs',[
                {
                    label: 'Settings',
                    name: ''
                }
            ]);
        }
    }
</script>
