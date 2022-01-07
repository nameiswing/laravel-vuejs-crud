<template>
    <div class="container-fluid custom-modal" @click.self="setCurrentModal">
        <div class="card px-4 pt-5 pb-4 mx-auto shadow-sm m-auto" style="max-width:32rem">
            <div class="mb-4 d-flex align-items-center justify-content-between">
                <h2 class="card-title ms-3">Add Product</h2>
                <button
                    class="btn btn-outline-danger btn-sm rounded-pill border-0"
                    id="close-btn"
                    @click.self="setCurrentModal"
                >&times;</button>
            </div>
            <div class="card-body">
                <form class="mb-4">
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">
                            Name
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            class="form-control p-2"
                            required
                            v-model="product_name"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label for="description" class="form-label">
                            Description
                            <span class="text-danger">*</span>
                        </label>
                        <input
                            type="text"
                            name="description"
                            class="form-control p-2"
                            required
                            v-model="description"
                        />
                    </div>
                    <div class="row">
                        <div class="form-group mb-4 col">
                            <label for="quantity" class="form-label">
                                Quantity
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                name="quantity"
                                class="form-control p-2"
                                required
                                v-model="quantity"
                            />
                        </div>
                        <div class="form-group mb-4 col">
                            <label for="quantity" class="form-label">
                                Price
                                <span class="text-danger">*</span>
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                name="price"
                                class="form-control p-2"
                                required
                                v-model="price"
                            />
                        </div>
                    </div>
                    <button class="btn btn-success w-100 mt-3" style="height: 3rem" @click.prevent="addProduct">Add</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

// import axios from "axios";
// import swal from "sweetalert";

export default {
    data() {
        return {
            product_name: "",
            description: "",
            quantity: 0,
            price: 0,
            status: 'enabled',
        }
    },
    computed: {
        currentModal() {
            return this.$store.state.currentModal;
        },
        productInfo() {
            return {
                name: this.product_name,
                description: this.description,
                quantity: this.quantity,
                price: this.price,
                status: this.status,
            }
        }
    },
    methods: {
        setCurrentModal() {
            this.$store.commit('setModal', { value: '' });
        },
        resetInput () {
            this.product_name = "";
            this.description = "";
            this.quantity = 0;
            this.price = 0;
        },
        addProduct() {
            console.log('working')
            this.axios.post("/api/add-product", this.productInfo).then(res => {
                if (res.data.status === 200) {
                    console.log(res.data.message);
                    this.$swal('Success!', res.data.message, "success");
                    this.$store.commit('incrementCounter');
                    this.resetInput();
                } else {
                    console.log('Unable to fetch products data.')
                }
            })
        },
    },

}
</script>

<style scoped>
.custom-modal {
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    inset: 0;
    height: 100vh;
    width: 100vw;
    display: flex;
}
#close-btn {
    transform: translate(0.75rem, -2.5rem);
    padding: 0rem 0.625rem;
    font-size: 1.5rem;
}
</style>