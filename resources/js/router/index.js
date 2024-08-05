import { createRouter, createWebHistory } from "vue-router";
import { getAuth } from "../boot";
import store from "../store";


const cl =  console.log;
const ifNotAuthenticated = (_to, _from, next) => {
    if (!getAuth()) {
        next();
    }
    else next({ name: 'dashboard' })
}

const ifAuthenticated = (_to, _from, next) => {
    if (getAuth()){
        next();
    }
    else {
        next({ name: 'login' })
    }
}

const routes=[
    {
        path: '/',
        name: 'basepath',
        requiresAuth: false,
        beforeEnter: ifNotAuthenticated,
        component: () => import('../components/Login.vue'),
    },
    {
        path: '/login',
        name: 'login',
        requiresAuth: false,
        beforeEnter: ifNotAuthenticated,
        component: () => import('../components/Login.vue'),
    },
    {
        path: '/forgot-password',
        name: 'forgot-password',
        requiresAuth: false,
        beforeEnter: ifNotAuthenticated,
        component: () => import('../components/ForgotPassword.vue'),
    },
    // Dashboard routes
    {
        path: "/dashboard",
        name: 'dashboard',
        beforeEnter: ifAuthenticated,
        component: () => import('../components/Dashboard.vue'),
    },
    // Settings routes
    {
        path: "/settings",
        name: 'settings',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/settings/index.vue'),
    },
    {
        path: "/setting-create",
        name: 'create-setting',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/settings/create.vue'),
    },
    {
        path: "/settings-view/:id/view",
        name: 'view-setting',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/settings/show.vue'),
    },
    {
        path: "/settings/:id/edit",
        name: 'edit-setting',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/settings/edit.vue'),
    },
      // Users routes
      {
        path: "/users",
        name: 'users',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/users/index.vue'),
    },
    {
        path: "/user-create",
        name: 'create-user',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/users/create.vue'),
    },
    {
        path: "/users/:id/edit",
        name: 'edit-user',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/users/edit.vue'),
    },
    {
        path: "/users-view/:id/view",
        name: 'view-user',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/users/show.vue'),
    },
    
    // Repositories routes
    {
        path: "/repositories-list",
        name: 'repositories',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/repositories/index.vue'),
    },
    {
        path: "/repositories-view/:id/view",
        name: 'view-repository',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/repositories/show.vue'),
    },
    {
        path: "/repository-create",
        name: 'create-repository',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/repositories/create.vue'),
    },
    {
        path: "/repositories/:id/edit",
        name: 'edit-repository',
        beforeEnter: ifAuthenticated,
        component: () => import('./../components/repositories/edit.vue'),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router
