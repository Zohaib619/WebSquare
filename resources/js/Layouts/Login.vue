<template>
    <div class="row">
        <div class="card col-md-4 mx-auto" style="margin-top:19%;margin-bottom:100px;">
            <div class="card-body">
                <h2 class="text-center">Login</h2>
                <div class="alert alert-danger" v-if="error" role="alert">
                    {{ error }}
                </div>
                <form @submit.prevent="login">
                    <div class="mb-3">
                        <h6>Email</h6>
                        <input type="text" class="form-control" placeholder="Enter email" v-model="form.email" required />
                    </div>
                    <div class="mb-3">
                        <h6>Password</h6>
                        <input type="password" class="form-control" placeholder="Enter password" v-model="form.password"
                            required />
                    </div>
                    <p>
                        Don't have an account?
                        <router-link to="register">Register</router-link>
                    </p>
                    <button type="submit" class="btn btn-primary w-100">Button</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";

export default {
    setup() {
        let form = reactive({
            email: '',
            password: ''
        });
        let error = ref('');
        const router = useRouter();
        const store = useStore();
        // calling api
        const login = async () => {
            await axios.post("api/login", form).then(res => {
                if (res.data.status) {
                    store.dispatch('setToken', res.data.data.token)
                    router.push({ name: 'Home' })
                } else {
                    error.value = res.data.message;
                }
            })
        }
        return {
            form,
            login,
            error
        }
    }
};
</script>