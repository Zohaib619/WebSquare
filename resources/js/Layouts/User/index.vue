<template>
    <div class="container p-5">

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
                            <h6>Username</h6>
                            <input type="text" class="form-control" v-model="form.username">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateCustomer">Update</button>
                    </div>
                </div>
            </div>
        </div>


        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Avator</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody v-if="users.length > 0">
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>
						<img v-bind:src="user.avator" width="100" height="100" alt="">
					</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.username }}</td>
                    <td>{{ user.email }}</td>
                    <td class="d-flex justify-content-evenly">
                        <button type="button" @click="editUser(user)" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger ms-2" @click="deleteProduct(user.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="6">
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
        const users = ref([]);
        const errors = ref('');
        const user_id = ref([]);
        const form = reactive({
            name: "",
            email: "",
            username: "",
            avator: "",
        });

        // Get Product
        const getUsers = async () => {
            axios.get("http://localhost:8000/api/users").then(res => {
                users.value = res.data.data;
                $(".errors").hide();
            })
        };

        // Add Product
        const storeUser = async () => {
            await axios.post("api/user-add", form).then(res => {
                console.log(res)
                if (res.data.status) {
                    getUsers();
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
            user_id.value = '';
            form.name = '';
            form.email = '';
            form.username = '';
        };

        // Update Product
        const updateCustomer = async () => {
            await axios.put(`api/user-update/${user_id.value}`, form).then(res => {
                if (res.data.status) {
                    getUsers();
                    formReset();
                    $("#staticBackdrop").modal('hide');
                } else {
                    $(".errors").show();
                    errors.value = res.data.message;
                }
            })
        }

        // Edit Product
        const editUser = (user) => {
            user_id.value = user.id;
            form.name = user.name;
            form.email = user.email;
            form.username = user.username;
        }

        // Delete Product
        const deleteProduct = async (id) => {
            if (confirm("Do you want to delete this record?")) {
                axios.delete(`api/user-delete/${id}`);
                getUsers();
            }

        }

        onMounted(getUsers);

        return {
            users,
            form,
            errors,
            storeUser,
            editUser,
            updateCustomer,
            formReset,
            user_id,
            deleteProduct
        }

    }
}
</script>