

<template>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary" v-if="$store.getters.getToken != 0">
        <div class="container">
            <a class="navbar-brand" href="#">Web Square </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link active" aria-current="page" to="/home">Home</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link " aria-current="page" to="/customer">Customer</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link " aria-current="page" to="/product">Product</router-link>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link text-danger" aria-current="page" @click="logout">Logout</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar end -->

    <!-- All Page render here -->
    <div class="container">
        <router-view />
    </div>
</template>

<script>
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
export default {
    setup() {
        const store = useStore();
        const router = useRouter();

        function logout() {
            store.dispatch('removeToken')
            router.push({ name: 'Login' })
        }
        return { logout };
    }
}
</script>