import { createWebHistory, createRouter } from 'vue-router';
import store from './Store';
// Importing all pages route
import login from "./Layouts/Login.vue";
import register from "./Layouts/Register.vue";
import home from "./Layouts/Home.vue";
import customer from "./Layouts/Customer.vue";
import sale from "./Layouts/Sale.vue";

// Product  
import product from "./Layouts/Product/index.vue";
import productAdd from "./Layouts/Product/add.vue";

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
        path: "/product",
        name: "Product",
        component: product,
        meta: {
            AuthToken: true
        }
    },
    {
        path: "/product/add",
        name: "Product_Add",
        component: productAdd,
        meta: {
            AuthToken: true
        }
    },
    {
        path: "/sale",
        name: "Sale",
        component: sale,
        meta: {
            AuthToken: true
        }
    },
    {
        path: "/customer",
        name: "Customer",
        component: customer,
        meta: {
            AuthToken: true
        }
    },
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