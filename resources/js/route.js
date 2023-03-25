import { createWebHistory, createRouter } from 'vue-router';
import store from './Store';
// Importing all pages route
import login from "./Layouts/Login.vue";
import register from "./Layouts/Register.vue";
import home from "./Layouts/Home.vue";
import sale from "./Layouts/Sale.vue";

// User
import user from "./Layouts/User/index.vue";

// Customer
import customer from "./Layouts/Customer/index.vue";

// Product  
import product from "./Layouts/Product/index.vue";

// naming routes
const routes = [
    {
        path: "/",
        name: "Login",
        component: login,
        meta: {
            AuthToken: false
        }
    },
    {
        path: "/register",
        name: "Register",
        component: register,
        meta: {
            AuthToken: false
        }
    },
    {
        path: "/home",
        name: "Home",
        component: home,
        meta: {
            AuthToken: true
        }
    },
    {
        path: "/user",
        name: "User",
        component: user,
        meta: {
            AuthToken: true
        }
    },
    // product
    {
        path: "/product",
        name: "Product",
        component: product,
        meta: {
            AuthToken: true
        }
    },
    
    // product end
    {
        path: "/sale",
        name: "Sale",
        component: sale,
        meta: {
            AuthToken: true
        }
    },
    // Customer
    {
        path: "/customer",
        name: "Customer",
        component: customer,
        meta: {
            AuthToken: true
        }
    },
    // Customer End
];


// Binding route with vue's route
const router = createRouter({
    history: createWebHistory(),
    routes
});

// check if route have token
router.beforeEach((to,from) => {
    if(to.meta.AuthToken && store.getters.getToken == 0){
        return { name: "Login" }
    }
    if(to.meta.AuthToken == false && store.getters.getToken != 0){
        return { name: "Home" }
    }
})
export default router;