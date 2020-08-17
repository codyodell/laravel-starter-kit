require("../bootstrap");

window.Vue = require("vue");

import "@mdi/font/css/materialdesignicons.css";
import "vuetify/dist/vuetify.min.css";
import Vue from "vue";
import Vuetify from "vuetify";

Vue.use(Vuetify);

// app
import router from "./router";
import store from "../common/Store";
import eventBus from "../common/Event";
import formatters from "../common/Formatters";
import AxiosAjaxDetct from "../common/AxiosAjaxDetect";

Vue.use(formatters);
Vue.use(eventBus);

const front = new Vue({
    vuetify: new Vuetify({
        theme: {
            themes: {
                dark: {
                    primary: "#6479f6",
                    info: "#95affb",
                    success: "#65b25f",
                    secondary: "#bfc7d5",
                    accent: "#ffcb6b",
                    error: "#ff5874"
                }
            }
        },
        icons: {
            iconfont: "mdi"
        }
    }),
    el: "#app",
    eventBus,
    router,
    store,
    data: () => ({
        drawer: true,
        page_name: "Home"
    }),
    created() {
        this.$vuetify.theme.dark = true;
    },
    computed: {
        getTopMenuItems() {
            return [];
        },
        getBreadcrumbs() {
            return store.getters.getBreadcrumbs;
        },
        showLoader() {
            return;
        },
        showSnackbar: {
            get() {
                return;
            },
            set(val) {
                if (!val) store.commit("hideSnackbar");
            }
        },
        showDrawer: {
            get() {
                return store.getters.showDrawer;
            },
            set(val) {
                if (!val) store.commit("hideDrawer");
            }
        },
        snackbarMessage() {
            return;
        },
        snackbarColor() {
            return;
        },
        snackbarDuration() {
            return;
        },
        showDialog: {
            get() {
                return;
            },
            set(val) {
                if (!val) store.commit("hideDialog");
            }
        },
        dialogType() {
            return store.getters.dialogType;
        },
        dialogTitle() {
            return;
        },
        dialogMessage() {
            return;
        },
        dialogIcon() {
            return store.getters.dialogIcon;
        }
    },
    mounted() {
        const self = this; // Progress bar top
        AxiosAjaxDetct.init(
            () => {
                self.$Progress.start();
            },
            () => {
                self.$Progress.finish();
            }
        );
    },
    methods: {
        menuClick(routeName, routeType) {
            let rn = routeType || "vue";
            if (rn === "vue") {
                this.$router.push({ name: routeName });
            }
            if (rn === "full_load") {
                window.location.href = routeName;
            }
        },
        dialogOk() {
            store.commit("dialogOk");
        },
        dialogCancel() {
            store.commit("dialogCancel");
        },
        toggleDrawer() {
            this.showDrawer = !this.showDrawer;
        }
    }
});
