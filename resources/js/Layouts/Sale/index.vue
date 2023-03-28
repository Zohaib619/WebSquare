<template>
    <div class="container p-5">


        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary mb-3 me-3" data-bs-toggle="modal" data-bs-target="#staticBackdrop1"
            @click="getProduct">
            Add Sale
        </button>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop1" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdrop1Label" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdrop1Label">Add Sale</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <td>ID</td>
                                    <td>Name</td>
                                    <td>Wholesale Price</td>
                                    <td>Retail Price</td>
                                    <td>QTY</td>
                                    <td>Total </td>
                                    <td> </td>
                                </tr>
                            </thead>
                            <tbody class="align-middle ">
                                <tr v-for="product in products" :key="product.id">
                                    <td>{{ product.id }}</td>
                                    <td>
                                        <h5>
                                            {{ product.name }}
                                        </h5>
                                        {{ product.description }}
                                    </td>
                                    <td>{{ product.wholesale_price }}</td>
                                    <td>{{ product.retail_price }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="product.qty"
                                            style="width: 80px;">
                                    </td>

                                    <td>
                                        <div class="total" v-if="(product.qty * product.retail_price) > 0"> {{ product.qty *
                                            product.retail_price }}</div>
                                        <div class="total" v-else> 0</div>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning"
                                            @click="storeProduct(product.id, product.qty)">Add</button>
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reference</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Qty</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>

            <tbody v-if="sales.length > 0">
                <tr v-for="sale in sales" :key="sale.id">

                    <td>{{ sale.id }}</td>
                    <td>{{ sale.reference }}</td>
                    <td>{{ sale.customer_name }}</td>
                    <td>{{ sale.product_name }}</td>
                    <td>{{ sale.product_retail_price }}</td>
                    <td>
                        <input type="number" v-model="sale.qty" style="width:80px;display: block;">
                        {{ sale.product_qty }}
                    </td>
                    <td>
                        <p v-if="sale.qty">
                            {{ sale.total * sale.qty }}
                        </p>
                        <p v-else>
                            {{ sale.total }}
                        </p>
                    </td>
                    <td>
                        <div class="d-flex justify-content-evenly">

                            <button type="button" @click="updateSale(sale.id, sale.qty)" class="btn btn-primary">
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger ms-2" @click="deleteSale(sale.id)">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr>
                    <td colspan="8">
                        <div class="d-flex justify-content-center">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td colspan="6">
                        <h5 class="text-end">Grand Total</h5>
                    </td>
                    <td colspan="">
                        <h6> {{ grand_total }}</h6>
                    </td>
                    <td>
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
        const sales = ref([]);
        const product_id = ref([]);
        const grand_total = ref('');

        // Get Product
        const getProduct = async () => {
            axios.get("http://localhost:8000/api/products").then(res => {
                products.value = res.data.data;
            })
        };

        // Get Sales
        const getSales = async () => {
            axios.get("http://localhost:8000/api/sales").then(res => {
                sales.value = res.data.data.sales;
                grand_total.value = res.data.data.grand_total;
            })
        };

        // Add Product
        const storeProduct = async (product_id, product_qty) => {
            console.log(product_id, product_qty);
            if (product_qty < 0) {
                alert("Qty must be greater than 0")
            } else {
                await axios.post("api/sale-add", { "product_id": product_id, "product_qty": product_qty }).then(res => {
                    if (res.data.status) {
                        getSales();
                        $("#staticBackdrop1").modal('hide');

                    } else {
                        alert(res.data.message)
                    }
                })
            }
        }

        // Update Product
        const updateSale = async (sale_id, product_qty) => {
            console.log(sale_id, product_qty);
            await axios.put(`api/sale-update/${sale_id}`, { product_qty: product_qty }).then(res => {
                console.log(res.data);
                if (res.data.status) {
                    getSales();
                } else {
                    alert("Record not updated")
                }
            })
        }

        // Delete Product
        const deleteSale = async (id) => {
            console.log(id);
            if (confirm("Do you want to delete this record?")) {
                axios.delete(`api/sale-delete/${id}`);
                getSales();
            }
        }

        onMounted(getSales);

        return {
            products,
            grand_total,
            sales,
            storeProduct,
            updateSale,
            getProduct,
            product_id,
            deleteSale
        }
    }
}
</script>