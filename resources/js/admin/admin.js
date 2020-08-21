import "babel-polyfill";

require("../bootstrap");

import "vuetify/dist/vuetify.min.css";
import "@mdi/font/css/materialdesignicons.css";

import Vue from "vue";
import vuetify from "../plugins/vuetify";
import _ from "lodash";
import router from "./router";
import store from "../common/Store";
import eventBus from "../common/Event";
import formatters from "../common/Formatters";
import AxiosAjaxDetect from "../common/AxiosAjaxDetect";

import VueProgressBar from "vue-progressbar";
import VueTimeago from "vue-timeago";

Vue.use(VueTimeago, {
    name: "Timeago", // Component name, `Timeago` by default
    locale: "en", // Default locale
    // We use `date-fns` under the hood
    // So you can use all locales from it
    locales: {
        "zh-CN": require("date-fns/locale/zh_cn"),
        ja: require("date-fns/locale/ja")
    }
});

Vue.use(require("vue-moment"));

// this is the progress bar settings, you can change colors here to fit on your needs or match your theming above
Vue.use(VueProgressBar, {
    color: "#dbdbdb",
    failedColor: "#fea19c",
    thickness: "4px",
    transition: {
        speed: "0.2s",
        opacity: "0.6s",
        termination: 300
    },
    autoRevert: true,
    inverse: false
});

// global component registrations here
Vue.component("moon-loader", require("vue-spinner/src/MoonLoader.vue").default);

Vue.use(formatters);
Vue.use(eventBus);

var Readable = {
    computed: {
        slug() {
            if (this.page_name) {
                return _.kebabCase(this.page_name);
            }
        }
    }
};

new Vue({
    el: "#admin",
    mixins: [Readable],
    vuetify,
    eventBus,
    router,
    store,
    data: () => ({
        drawer: true
    }),
    created() {
        this.$vuetify.theme.dark = true;
    },
    mounted() {
        const self = this;
        let isFirstPage = this.$route.name === "dashboard";
        if (!isFirstPage) {
            self.$store.commit("showDrawer", false);
        }
        // progress bar top
        AxiosAjaxDetct.init(
            () => {
                self.$Progress.start(),
            },
            () => {
                self.$Progress.finish()
            }
        );
    },
    computed: {
        getTopMenuItems() {
            return [{
                    title: "Your Profile",
                    route: "/admin/users/1",
                    icon: "mdi-card-account-details"
                },
                {
                    title: "Settings",
                    route: route("settings")
                },
                {
                    title: "Logout",
                    route: route("logout")
                }
            ];
        },
        getBreadcrumbs() {
            return store.getters.getBreadcrumbs;
        },
        showLoader() {
            return store.getters.showLoader;
        },
        showDrawer: {
            get() {
                return store.getters.showDrawer;
            },
            set(val) {
                if (!val) store.commit("hideDrawer");
            }
        },
        showSnackbar: {
            get() {
                return store.getters.showSnackbar;
            },
            set(val) {
                if (!val) store.commit("hideSnackbar");
            }
        },
        snackbarMessage() {
            return store.getters.snackbarMessage;
        },
        snackbarColor() {
            return store.getters.snackbarColor;
        },
        snackbarDuration() {
            return store.getters.snackbarDuration;
        },
        // dialog
        showDialog: {
            get() {
                return store.getters.showDialog;
            },
            set(val) {
                if (!val) store.commit("hideDialog");
            }
        },
        dialogType() {
            return store.getters.dialogType;
        },
        dialogTitle() {
            return store.getters.dialogTitle;
        },
        dialogMessage() {
            return store.getters.dialogMessage;
        },
        dialogIcon() {
            return store.getters.dialogIcon;
        }
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
        clickLogout(logoutUrl, afterLogoutRedirectUrl) {
            axios.post(logoutUrl).then(r => {
                window.location.href = afterLogoutRedirectUrl;
            });
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
