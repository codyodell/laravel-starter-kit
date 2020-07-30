import Vue from "vue"
import Router from "vue-router"
import store from "../common/Store"

Vue.use(Router)

const router = new Router({
    base: "/",
    routes: [{
        name: "home",
        path: "/home",
        component: require("./home/Home")
    }, {
        name: "login",
        path: "/login",
        component: require("./login/Login")
    }, {
        name: "register",
        path: "/register",
        component: require("./Register/Register")
    }, {
        name: "dashboard",
        path: "/dashboard",
        component: require("../admin/dashboard/Admin")
    }]
})

router.beforeEach((to, from, next) => {
    store.commit("showLoader")
    next()
})

router.afterEach(() => {
    setTimeout(() => {
        store.commit("hideLoader")
    }, 1000)
})

export default router
