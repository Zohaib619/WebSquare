<template>
	<div class="container p-5">


		<!-- Button trigger modal -->
		<button type="button" @click="formReset" class="btn btn-primary mb-3" data-bs-toggle="modal"
			data-bs-target="#staticBackdrop" on-click="formReset">
			Add Product
		</button>

		<!-- Modal -->
		<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
			aria-labelledby="staticBackdropLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
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
							<h6>Description</h6>
							<textarea class="form-control" v-model="form.description" cols="30" rows="5"></textarea>
						</div>
						<div class="mb-3">
							<h6>Wholesale Price</h6>
							<input type="number" class="form-control" v-model="form.wholesale_price">
						</div>
						<div class="mb-3">
							<h6>Retail Price</h6>
							<input type="number" class="form-control" v-model="form.retail_price">
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" v-if="product_id == ''" class="btn btn-primary" @click="storeProduct">Add
							Product</button>

						<button v-else type="button" class="btn btn-primary" @click="updateProduct">Update</button>
					</div>
				</div>
			</div>
		</div>


		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Description</th>
					<th>Wholesale Price</th>
					<th>Retail Price</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody v-if="products.length > 0">
				<tr v-for="product in products" :key="product.id">
					<td>{{ product.id }}</td>
					<td>{{ product.name }}</td>
					<td>{{ product.description }}</td>
					<td>{{ product.wholesale_price }}</td>
					<td>{{ product.retail_price }}</td>
					<td class="d-flex justify-content-evenly">
						<button type="button" @click="editProduct(product)" class="btn btn-primary" data-bs-toggle="modal"
							data-bs-target="#staticBackdrop">
							Edit
						</button>
						<button type="button" class="btn btn-danger ms-2" @click="deleteProduct(product.id)">Delete</button>
					</td>
				</tr>
			</tbody>
			<tbody v-else>
				<tr>
					<td colspan="6">
						<div class="d-flex justify-content-center">
							<div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
								<span class="visually-hidden">Loading...</span>
							</div>
						</div>
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
		const products = ref([]);
		const errors = ref('');
		const product_id = ref([]);
		const form = reactive({
			name: "",
			description: "",
			wholesale_price: "",
			retail_price: "",
		});

		// Get Product
		const getProducts = async () => {
			axios.get("http://localhost:8000/api/products").then(res => {
				products.value = res.data.data;
				$(".errors").hide();
			})
		};

		// Add Product
		const storeProduct = async () => {
			await axios.post("api/product-add", form).then(res => {
				console.log(res)
				if (res.data.status) {

					getProducts();
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
			product_id.value = '';
			form.name = '';
			form.description = '';
			form.wholesale_price = '';
			form.retail_price = '';
		};

		// Update Product
		const updateProduct = async () => {
			await axios.put(`api/product-update/${product_id.value}`, form).then(res => {
				if (res.data.status) {
					getProducts();
					formReset();
					$("#staticBackdrop").modal('hide');
				} else {
					$(".errors").show();
					errors.value = res.data.message;
				}
			})
		}

		// Edit Product
		const editProduct = (product) => {
			product_id.value = product.id;
			form.name = product.name;
			form.description = product.description;
			form.wholesale_price = product.wholesale_price;
			form.retail_price = product.retail_price;
		}

		// Delete Product
		const deleteProduct = async (id) => {
			if (confirm("Do you want to delete this record?")) {
				axios.delete(`api/product-delete/${id}`);
				getProducts();
			}

		}

		onMounted(getProducts);

		return {
			products,
			form,
			errors,
			storeProduct,
			editProduct,
			updateProduct,
			formReset,
			product_id,
			deleteProduct
		}

	}
}
</script>