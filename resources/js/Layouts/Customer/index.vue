<template>
    <div class="container p-5">
        <!-- Button trigger modal -->
        <button type="button" @click="formReset" class="btn btn-primary mb-3" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop" on-click="formReset">
            Add Customer
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Customer</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="alert alert-secondary errors" role="alert">
                            {{ errors }}
                        </div>
                        <div class="mb-3">
                            <h6>Name</h6>
                            <input type="text" class="form-control" v-model="form.name">
                        </div>
                        <div class="mb-3">
                            <h6>Email</h6>
                            <input type="email" class="form-control" v-model="form.email">
                        </div>
                        <div class="mb-3">
                            <h6>Phone Number</h6>
                            <input type="number" class="form-control" v-model="form.phone">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" v-if="customer_id == ''" class="btn btn-primary" @click="storeCustomer">Add
                            Customer</button>
                        <button v-else type="button" class="btn btn-primary" @click="updateCustomer">Update</button>
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody v-if="customers.length > 0">
                <tr v-for="customer in customers" :key="customer.id">
                    <td>{{ customer.id }}</td>
                    <td>{{ customer.name }}</td>
                    <td>{{ customer.email }}</td>
                    <td>{{ customer.phone }}</td>
                    <td class="d-flex justify-content-evenly">
                        <button type="button" @click="editCustomer(customer)" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger ms-2" @click="deleteProduct(customer.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="5">
                        <h4 class="text-center">Loading...</h4>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
import { ref, reactive, onMounted } from 'vue';
import axios from 'axios';
export default {
    setup() {
        const customers = ref([]);
        const errors = ref('');
        const customer_id = ref([]);
        const form = reactive({
            name: "",
            email: "",
            phone: "",
        });

        // Get Product
        const getCustomers = async () => {
            axios.get("http://localhost:8000/api/customers").then(res => {
                customers.value = res.data.data;
                $(".errors").hide();
            })
        };

        // Add Product
        const storeCustomer = async () => {
            await axios.post("api/customer-add", form).then(res => {
                console.log(res)
                if (res.data.status) {
                    getCustomers();
                    formReset();
                    $("#staticBackdrop").modal('hide');
                } else {
                    $(".errors").show();
                    errors.value = res.data.message;
                }
            })
        }
        // Form reset
        const formReset = () => {
            customer_id.value = '';
            form.name = '';
            form.email = '';
            form.phone = '';
        };

        // Update Product
        const updateCustomer = async () => {
            await axios.put(`api/customer-update/${customer_id.value}`, form).then(res => {
                if (res.data.status) {
                    getCustomers();
                    formReset();
                    $("#staticBackdrop").modal('hide');
                } else {
                    $(".errors").show();
                    errors.value = res.data.message;
                }
            })
        }

        // Edit Product
        const editCustomer = (customer) => {
            customer_id.value = customer.id;
            form.name = customer.name;
            form.email = customer.email;
            form.phone = customer.phone;
        }

        // Delete Product
        const deleteProduct = async (id) => {
            if (confirm("Do you want to delete this record?")) {
                axios.delete(`api/customer-delete/${id}`);
                getCustomers();
            }

        }

        onMounted(getCustomers);

        return {
            customers,
            form,
            errors,
            storeCustomer,
            editCustomer,
            updateCustomer,
            formReset,
            customer_id,
            deleteProduct
        }

    }
}
</script>