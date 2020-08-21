// import "babel-polyfill";

require("../bootstrap");

import "@mdi/font/css/materialdesignicons.css";

import Vue from "vue";
import _ from "lodash";
import vuetify from "../plugins/vuetify";
import Readable from "../common/Mixins";
import VueProgressBar from "vue-progressbar";

import router from "./router";
import store from "../common/Store";
import eventBus from "../common/Event";
import formatters from "../common/Formatters";
import AxiosAjaxDetect from "../common/AxiosAjaxDetect";

Vue.use(formatters);
Vue.use(eventBus);
Vue.use(VueProgressBar, {
    color: "#dbdbdb",
    failedColor: "#fea19c",
    thickness: "4px",
    transition: {
        speed: "0.2s",
        opacity: "0.4s",
        termination: 300
    },
    autoRevert: true,
    inverse: false
});

// Global Components
Vue.component("moon-loader", require("vue-spinner/src/MoonLoader.vue").default);

new Vue({
    el: "#app",
    mixins: [Readable],
    vuetify,
    eventBus,
    router,
    store,
    data: () => ({
        drawer: true,
        nav_top: [{
                label: "Home",
                title: "Go to Homepage",
                icon: "mdi-home",
                routeName: "home"
            },
            {
                label: "Login",
                title: "Login to Your Account",
                icon: "mdi-login",
                routeName: "login"
            },
            {
                label: "Register",
                title: "Signup for an Account",
                icon: "mdi-account",
                routeName: "register"
            }
        ],
        nav_social: [{
                title: "Follow us on Twitter",
                url: "https://www.twitter.com/",
                icon: "mdi-twitter"
            },
            {
                title: "Facebook",
                url: "https://www.facebook.com/",
                icon: "mdi-facebook"
            },
            {
                title: "Reddit",
                url: "https://www.reddit.com/",
                icon: "mdi-reddit"
            },
            {
                title: "GitHub",
                url: "https://www.github.com/",
                icon: "mdi-github"
            }
        ]
    }),
    created() {
        this.$vuetify.theme.dark = true;
    },
    mounted() {
        const self = this;
        // Progress bar top
        AxiosAjaxDetect.init(
            () => {
                self.$Progress.start();
            },
            () => {
                self.$Progress.finish();
            }
        );
    },
    computed: {
        getTopMenuItems() {
            return this.nav_top;
        },
        getBreadcrumbs() {
            return store.getters.getBreadcrumbs;
        },
        showLoader() {
            return store.getters.showLoader;
        },
        showSnackbar: {
            get() {
                return store.getters.showSnackbar;
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
            return store.getters.snackbarMessage;
        },
        snackbarColor() {
            return store.getters.snackbarColor;
        },
        snackbarDuration() {
            return store.getters.snackbarDuration;
        },
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
