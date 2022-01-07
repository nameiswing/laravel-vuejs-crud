<template>
    <div class="container-fluid p-0 custom-modal" @click.self="setCurrentModal">
        <div class="card px-4 pt-5 pb-4 shadow-sm m-auto" style="width:clamp(24rem, 90vw, 36rem)">
            <div class="mb-3 d-flex align-items-center justify-content-between">
                <h2 class="card-title ms-3">Orders</h2>
                <button
                    class="btn btn-outline-danger btn-sm rounded-pill border-0"
                    id="close-btn"
                    @click.self="setCurrentModal"
                >&times;</button>
            </div>
            <table class="table w-100">
                <thead>
                    <tr class="table-success py-2 my-0">
                        <th class="p-2 text-success">Order ID</th>
                        <th class="p-2 text-success">Name</th>
                        <th class="p-2 text-success">Price</th>
                    </tr>
                </thead>
                <tbody >
                    <template v-if="orders.length === 0">
                        <tr class="bg-light py-2 my-0 border border-top-0">
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                        </tr>
                        <tr class="bg-light py-2 my-0 border border-top-0">
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                        </tr>
                        <tr class="bg-light py-2 my-0 border border-top-0">
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                            <td class="p-2 text-center"> - </td>
                        </tr>
                    </template>
                    <template v-if="orders.length > 0">
                        <tr class="bg-light py-2 my-0 border border-top-0" v-for="item in orders" :key="item.id">
                            <td class="p-2">{{item.order_id}}</td>
                            <td class="p-2">{{item.name}}</td>
                            <td class="p-2">{{item.price}}</td>
                        </tr>
                    </template>
                    <tr class="bg-light py-2 my-0 border">
                        <td class="p-2"><b>Total</b></td>
                        <td class="p-2"></td>
                        <td class="p-2" v-if="orders.length > 0">{{totalOrderPrice.price}}</td>
                        <td class="p-2 text-center" v-else>0</td>
                    </tr>
                </tbody>
            </table>
                <button class="btn btn-success w-100 mt-3" style="height: 3rem" @click.prevent="archiveOrder">Confirm Purchase</button>
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
        },
        orders() {
            return this.$store.state.orders;
        },
        totalOrderPrice() {
             return this.$store.state.orders.reduce( (a,b) => ({price:(a.price + b.price)}) );
        }
    },
    methods: {
        setCurrentModal() {
            this.$store.commit('setModal', { value: '' });
        },
        archiveOrder() {
            this.axios.post('api/archive-orders', this.orders).then( res => {
                if(res.data.status === 200){
                    console.log(res.data.message);
                    this.$swal(res.data.message);
                    this.setCurrentModal();
                    this.$store.commit('clearOrders');
                    this.$store.commit('incrementCounter');
                };
            })
        }
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