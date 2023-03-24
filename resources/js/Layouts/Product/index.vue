<template>
    <router-link class="btn btn-primary mb-3" to="product/add">Add Product</router-link>

    <!-- Product -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Retail Price</th>
                    <th>Wholesale Price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, index) in products" :key="index">
                    <td>{{ product.id }}</td>
                    <td>{{ product.name }}</td>
                    <td>{{ product.description }}</td>
                    <td>{{ product.retail_price }}</td>
                    <td>{{ product.wholesale_price }}</td>
                    <td class="d-flex justify-content-evenly">
                        <button class="btn btn-danger mx-2">Del</button>
                        <button class="btn btn-warning mx-2">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- Product End  -->
</template>

<script>
    export default {
        data(){
            return{
                products: []
            }    
        },
        mounted(){
            this.get_products();
        },
        methods: {
            async get_products(){
                await axios.get("http://localhost:8000/api/products").then(res => {
                    this.products = res.data.data 
                })
            }
        }
    }

</script>