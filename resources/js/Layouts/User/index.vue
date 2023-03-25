<template>
	<div class="container p-5">


		<!-- Button trigger modal -->
		<button type="button" @click="formReset" class="btn btn-primary mb-3" data-bs-toggle="modal"
			data-bs-target="#staticBackdrop">
			Add User
		</button>

		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Add User</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">

						<div class="text-sm text-danger" if="errors != ''">
							<p v-for="error in errors" class="mb-0" :key="error"><small>{{ error }} </small></p>
						</div>
						<div class="form-group">
							<label>Name</label>
							<input type="text" class="form-control" v-model="form.name">
						</div>
						<div class="form-group">
							<label>Username</label>
							<input type="text" class="form-control" v-model="form.username">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" v-model="form.email">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" v-model="form.password">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button v-if="employee_id == ''" type="button" class="btn btn-primary"
							@click="storeUser">Submit</button>

						<button v-else type="button" class="btn btn-primary" @click="updateEmployee">Update</button>
					</div>
				</div>
			</div>
		</div>


		<table class="table table-bordered table-hover">
			<thead>
				<th>ID</th>
				<th>Name</th>
				<th>Email</th>
				<th>Username</th>
				<th>Action</th>
			</thead>

			<tbody v-if="users.length > 0">
				<tr v-for="user in users" :key="user.id">
					<td>{{ user.id }}</td>
					<td>{{ user.name }}</td>
					<td>{{ user.email }}</td>
					<td>{{ user.username }}</td>
					<td>
						<!-- <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#myModal"
								@click="editEmployee(employee)">Edit</button>
							<button type="button" class="btn btn-sm btn-danger ml-2"
								@click="deleteEmployee(employee.id)">Delete</button> -->
					</td>
				</tr>
			</tbody>
			<tbody v-else>
				<tr>
                    <td colspan="5"><h4 class="text-center">Loading...</h4></td>

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
		const form = reactive({
			name: "",
			username: "",
			email: "",
			password: "",
		});

		// Get Users
		const getUsers = async () => {
			axios.get("http://localhost:8000/api/users").then(res => {
				users.value = res.data.data
			})
		};

		// Add User
		const storeUser = async () => {
			try{
				await axios.post("add-user", form).then(res => {
					console.log(res)
				})
			}catch{

			}
		}

		onMounted(getUsers);

		return {
			users,
			form,
			storeUser
		}

	}
}
</script>