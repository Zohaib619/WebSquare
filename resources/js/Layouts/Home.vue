<template>
    <div class="row">
        <div class="col-md-12">
            <h1>Home</h1>
            <button class="btn btn-danger" @click="logout">Logout</button>
        </div>
    </div>
</template>

<script>
    import {useRouter} from 'vue-router';
    export default {
        setup(){

            const router = useRouter();

            function logout(){
                localStorage.removeItem('token');
                router.push({name: 'Login'})
            }
            return {logout};
        }
    }
</script>