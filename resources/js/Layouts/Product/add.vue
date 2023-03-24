<template>
    <div class="row">
        <h1>Add Product</h1>
        <div class="col-md-6 m-auto">
            <div class="card">
                <div class="card-body">
                    <div v-if="error" class="alert alert-secondary" role="alert">
                        {{ error }}
                    </div>
                    <form @submit.prevent="add_product">
                        <div class="mb-3">
                            <h6>Product Name</h6>
                            <input type="text" class="form-control" v-model="product.name" placeholder="Type here...">
                        </div>
                        <div class="mb-3">
                            <h6>Product Description</h6>
                            <textarea name="" class="form-control" id="" cols="10" rows="5" v-model="product.description"
                                placeholder="Type here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <h6>Product Retail Price</h6>
                            <input type="number" class="form-control" placeholder="Type here..."
                                v-model="product.retail_price">
                        </div>
                        <div class="mb-3">
                            <h6>Product Wholesale Price</h6>
                            <input type="number" class="form-control" placeholder="Type here..."
                                v-model="product.wholesale_price">
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            Add Product
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import { useRouter } from "vue-router";

export default {
    setup() {
        let product = reactive({
            'name': '',
            'description': '',
            'retail_price': '',
            'wholesale_price': '',
        });

        let router = useRouter();
        let error = ref("");
        const add_product = async () => {
            await axios.post('http://localhost:8000/api/product-add', product).then(res => {
                console.log(res.data.status);
                if (res.data.status) {
                    error.value = 'Product Added'
                    router.push({ name: 'Product' })
                } else {
                    error.value = res.data.message
                }
            })
        }
        return {
            product,
            add_product,
            error
        }
    },
}

</script>