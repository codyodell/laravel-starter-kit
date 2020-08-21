import Vue from "vue";
import Vuetify from "vuetify";
import "vuetify/dist/vuetify.min.css";

Vue.use(Vuetify);

const Options = {
    theme: {
        themes: {
            dark: {
                primary: "#50ffca",
                info: "#007aff",
                success: "#a7fe9c",
                secondary: "#dbdbdb",
                accent: "#fef49c",
                error: "#fea19c"
            }
        }
    },
    icons: {
        iconfont: "mdi"
    }
};
export default new Vuetify(Options);
