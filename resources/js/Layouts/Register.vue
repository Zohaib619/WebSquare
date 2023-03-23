<template>
    <div class="row">
        <div class="card col-md-4 mx-auto" style="margin-top:19%;margin-bottom:100px;">
            <div class="card-body">
                <h2 class="text-center">Register</h2>
                <!-- <div class="alert alert-danger" v-if="errors" role="alert"> -->
                    <ul class="mb-0" v-for="error in errors" :key="error">
                        <li v-for="err in error" :key="err">{{ err }}</li>
                    </ul>
                <!-- </div> -->
                <form @submit.prevent="register">
                    <div class="mb-3">
                        <h6>Name</h6>
                        <input type="text" class="form-control" placeholder="Enter name" v-model="form.name" />
                    </div>
                    <div class="mb-3">
                        <h6>Username</h6>
                        <input type="text" class="form-control" placeholder="Enter username" v-model="form.username" />
                    </div>
                    <div class="mb-3">
                        <h6>Email</h6>
                        <input type="text" class="form-control" placeholder="Enter email" v-model="form.email" />
                    </div>
                    <div class="mb-3">
                        <h6>Password</h6>
                        <input type="password" class="form-control" placeholder="Enter password" v-model="form.password" />
                    </div>
                    <p>
                        Already have an account?
                        <router-link to="/">Login</router-link>
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
export default {
    setup() {
        let form = reactive({
            avator: '',
            name: '',
            username: '',
            email: '',
            password: ''
        });
        let errors = ref([]);
        const router = useRouter();
        // calling api
        const register = async () => {
            await axios.post("api/register", form).then(res => {
                if (res.data.status) {
                    localStorage.setItem('token', res.data.data.token);
                    router.push({ name: 'Home' })
                } else {
                    errors.value = res.data.message;
                }
            })
        }
        return {
            form,
            register,
            errors
        }
    }
};
</script>