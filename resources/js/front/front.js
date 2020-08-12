require("../bootstrap");

window.Vue = require("vue");

import "@mdi/font/css/materialdesignicons.css";
import "vuetify/dist/vuetify.min.css";
import Vue from "vue";
import Vuetify from "vuetify";
import VueProgressBar from "vue-progressbar";
import VueTimeago from "vue-timeago";

Vue.use(Vuetify);

Vue.use(VueProgressBar, {
  color: "#ffcb6b",
  failedColor: "#ff5874",
  thickness: "5px",
  transition: {
    speed: "0.2s",
    opacity: "0.6s",
    termination: 300
  },
  autoRevert: true,
  inverse: false
});

Vue.use(VueTimeago, {
  name: "Timeago",
  locales: {
    "zh-CN": require("date-fns/locale/zh_cn"),
    ja: require("date-fns/locale/ja")
  }
});

// global component registrations here
Vue.component("moon-loader", require("vue-spinner/src/MoonLoader.vue"));

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
    }
  }
});
