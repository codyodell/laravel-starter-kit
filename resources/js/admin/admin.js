
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// vendor
require('../bootstrap');
window.Vue = require('vue');

// 3rd party
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/dist/vuetify.min.css';
import Vue from 'vue';
import Vuetify from 'vuetify';
import VueProgressBar from 'vue-progressbar';
import VueTimeago from 'vue-timeago';

Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'en', // Default locale
    // We use `date-fns` under the hood
    // So you can use all locales from it
    locales: {
        'zh-CN': require('date-fns/locale/zh_cn'),
        ja: require('date-fns/locale/ja')
    }
});

Vue.use(require('vue-moment'));

// this is the vuetify theming options
// you can change colors here based on your needs
// and please dont forget to recompile scripts
Vue.use(Vuetify);

// this is the progress bar settings, you
// can change colors here to fit on your needs or match
// your theming above
Vue.use(VueProgressBar, {
    color: '#ffcb6b',
    failedColor: '#ff5874',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    inverse: false
});

// global component registrations here
Vue.component('moon-loader', require('vue-spinner/src/MoonLoader.vue'));

// app
import router from './router';
import store from '../common/Store';
import eventBus from '../common/Event';
import formatters from '../common/Formatters';
import AxiosAjaxDetct from '../common/AxiosAjaxDetect';

Vue.use(formatters);
Vue.use(eventBus);

const admin = new Vue({
    vuetify: new Vuetify({
        theme: {
            dark: true,
            themes: {
                dark: {
                    primary: '#6479f6',
                    info: '#95affb',
                    success: '#65b25f',
                    secondary: '#bfc7d5',
                    accent: '#ffcb6b',
                    error: '#ff5874',
                }
            },
        },
        icons: {
            iconfont: 'mdi'
        }
    }),
    el: '#admin',
    eventBus,
    router,
    store,
    data: () => ({
        drawer: true
    }),
    mounted() {
        const self = this;
        // progress bar top
        AxiosAjaxDetct.init(() => {
            self.$Progress.start();
        }, () => {
            self.$Progress.finish();
        });
    },
    computed: {
        getTopMenuItems() {
            return [
                {
                    title: 'Profile',
                    route: '/admin/users/1'
                }, {
                    title: 'Settings',
                    route: route('settings')
                }, {
                    title: 'Logout',
                    route: route('logout')
                }
            ];
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
                if (!val) store.commit('hideSnackbar');
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
                if (!val) store.commit('hideDialog');
            }
        },
        dialogType() {
            return store.getters.dialogType
        },
        dialogTitle() {
            return store.getters.dialogTitle
        },
        dialogMessage() {
            return store.getters.dialogMessage
        },
        dialogIcon() {
            return store.getters.dialogIcon
        },
    },
    methods: {
        menuClick(routeName, routeType) {

            let rn = routeType || 'vue';

            if (rn === 'vue') {
                this.$router.push({ name: routeName });
            }
            if (rn === 'full_load') {
                window.location.href = routeName;
            }
        },
        clickLogout(logoutUrl, afterLogoutRedirectUrl) {
            axios.post(logoutUrl).then((r) => {
                window.location.href = afterLogoutRedirectUrl;
            });
        },
        dialogOk() {
            store.commit('dialogOk');
        },
        dialogCancel() {
            store.commit('dialogCancel');
        }
    }
});
