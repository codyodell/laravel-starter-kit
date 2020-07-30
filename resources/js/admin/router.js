import Vue from 'vue'
import Router from 'vue-router'
import store from '../common/Store'

Vue.use(Router)

const router = new Router({
    base: '/admin',
    routes: [{
        path: '/',
        redirect: { name: 'dashboard' },
    }, {
        name: 'dashboard',
        path: '/dashboard',
        component: require('./dashboard/Admin'),
    }, {
        path: '/users',
        component: require('./users/Users'),
        children: [{
            path: '/',
            name: 'users.list',
            component: require('./users/components/UserLists'),
        }, {
            path: 'create',
            name: 'users.create',
            component: require('./users/components/UserFormAdd'),
        }, {
            path: 'edit/:id',
            name: 'users.edit',
            component: require('./users/components/UserFormEdit'),
            props: (route) => ({ propUserId: route.params.id }),
        }, {
            path: 'groups',
            name: 'users.groups.list',
            component: require('./users/components/GroupLists'),
        }, {
            path: 'groups/create',
            name: 'users.groups.create',
            component: require('./users/components/GroupFromAdd'),
        }, {
            path: 'groups/edit/:id',
            name: 'users.groups.edit',
            component: require('./users/components/GroupFromEdit'),
            props: (route) => ({
                propGroupId: route.params.id,
            }),
        }, {
            path: 'permissions',
            name: 'users.permissions.list',
            component: require('./users/components/PermissionLists'),
        }, {
            path: 'permissions/create',
            name: 'users.permissions.create',
            component: require('./users/components/PermissionFormAdd'),
        }, {
            path: 'permissions/edit/:id',
            name: 'users.permissions.edit',
            component: require('./users/components/PermissionFormEdit'),
            props: (route) => ({
                propPermissionId: route.params.id,
            }),
        }, ],
    }, {
        name: 'files',
        path: '/files',
        component: require('./files/Files'),
    }, {
        name: 'products',
        path: '/products',
        component: require('./products/Products'),
        children: [{
            name: 'product.lists',
            path: '/products',
            component: require('./products/components/ProductLists'),
        }, {
            name: 'product.categories',
            path: '/categories',
            component: require('./products/components/CategoryLists'),
        }, {
            name: 'product.brands',
            path: '/brands',
            component: require('./products/components/BrandLists'),
        }, {
            name: 'product.add',
            path: '/product/create',
            component: require('./products/components/ProductAdd'),
        }, {
            name: 'category.add',
            path: '/categories/create',
            component: require('./products/components/CategoryAdd'),
        }, {
            name: 'brand.add',
            path: '/brands/create',
            component: require('./products/components/BrandAdd'),
        }, {
            name: 'product.edit',
            path: '/products/edit/:id',
            component: require('./products/components/ProductEdit'),
            props: (route) => ({ propProductId: route.params.id }),
        }, {
            name: 'brand.edit',
            path: '/brands/edit/:id',
            component: require('./products/components/BrandEdit'),
            props: (route) => ({ propBrandId: route.params.id }),
        }, {
            name: 'category.edit',
            path: '/categories/edit/:id',
            component: require('./products/components/CategoryEdit'),
            props: (route) => ({ propCategoryId: route.params.id }),
        }, ],
    }, {
        name: 'settings',
        path: '/settings',
        component: require('./settings/Settings'),
    }, ],
})

router.beforeEach((to, from, next) => {
    store.commit('showLoader')
    next()
})

router.afterEach((to, from) => {
    setTimeout(() => {
        store.commit('hideLoader')
    }, 1000)
})

export default router
