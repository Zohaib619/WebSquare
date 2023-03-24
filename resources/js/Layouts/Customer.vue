<template>
    <!-- Button modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        Add Customer
    </button>

    <!-- Customer Add Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Customer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form @submit.prevent="add_customer">
                    <div class="modal-body">
                        <div class="alert alert-secondary" v-if="error" role="alert">
                            {{ error }}
                        </div>
                        <div class="mb-3">
                            <h6>Name</h6>
                            <input type="text" class="form-control" v-model="customer.name" placeholder="Type Here...">
                        </div>
                        <div class="mb-3">
                            <h6>Email</h6>
                            <input type="email" class="form-control" v-model="customer.email" placeholder="Type Here...">
                        </div>
                        <div class="mb-3">
                            <h6>Phone</h6>
                            <input type="number" class="form-control" v-model="customer.phone" placeholder="Type Here...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Customer Add Model End -->

    <!-- Customer Table -->
    <div class="table-responsive mt-3">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th></th>
                </tr>
            </thead>
            <tbody v-if="this.customers.length > 0">
                <tr v-for="(customer, index) in this.customers" :key="index">
                    <td> {{ customer.id }} </td>
                    <td>{{ customer.name }}</td>
                    <td>{{ customer.email }}</td>
                    <td>{{ customer.phone }}</td>
                    <td>
                        <button class="btn btn-danger">Delete</button>
                        <!-- Edit Customer -->
                        <button class="btn btn-primary ms-2">Edit</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td class="text-center" colspan="6"> <h4>Loading...</h4>  </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Customer Table End -->
</template>


<script>
import { reactive, ref } from 'vue';

export default {
    setup() {
        let customer = reactive({
            name: "", email: "", phone: ""
        })
        let error = ref('');
        const add_customer = async () => {
            await axios.post("api/add-customer", customer).then(res => {
                if (res.data.status) {
                    error.value = 'Customer Added'
                } else {
                    error.value = res.data.message
                }
            })
        }
        return {
            customer,
            add_customer,
            error,
        }
        
    },
    // fetching data
    data(){
        return {
            customers: []
        }
    },
    mounted(){
        this.get_customers();
    },
    methods: {
        // fetching customer 
        get_customers(){
            axios.get("api/customers").then(res => {
                this.customers = res.data.data;
                console.log(this.customers);
            })
        }
    }
}
</script>