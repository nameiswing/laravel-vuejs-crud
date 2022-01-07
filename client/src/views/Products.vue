<template>
    <div class="fs-4" v-if="isLoggedIn" >Hello, <b class="fw-bold text-capitalize text-success">{{accessType}}</b>!</div>
    <div class="card p-0 border-bottom-0 mt-2" v-if="isLoggedIn">
        <div class="mx-4 d-flex align-items-center justify-content-between">
            <h1 class="ms-2 my-4">Products</h1>
            <button
                v-if="accessType === 'admin'"
                class="btn btn-success me-2 px-4"
                style="height:3rem"
                @click="setCurrentModal('add-product')"
            >Add Product</button>
            <button
                v-if="accessType === 'customer'"
                class="btn btn-danger me-2 px-4"
                style="height:3rem"
                @click="setCurrentModal('view-order')"
            >View Orders</button>
        </div>
        <div class="table-responsive">
            <table class="table container-md m-0 border-top">
                <thead>
                    <tr>
                        <th class="p-3">Product Name</th>
                        <th class="p-3">Description</th>
                        <th class="p-3">Price</th>
                        <th class="p-3" v-if="accessType === 'admin'">Quantity</th>
                        <th class="p-3 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in list" :key="componentKey*item.id">
                        <ProductItem :item="item" />
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <PromptLogin v-if="!isLoggedIn" />
</template>


<script>

import ProductItem from "../components/ProductItem.vue";
import PromptLogin from "../components/PromptLogin.vue";

export default {
    name: "Products",
    components: {
        ProductItem,
        PromptLogin
    },
    data() {
        return {
            editable: false,
            sessionState: '',
            componentKey: 0,
        }
    },
    computed: {
        list() {
            return this.$store.state.products;
        },
        updateWatcher() {
            return this.$store.state.productUpdateCount;
        },
        accessType () {
            return this.$store.state.accessType;
        },
        isLoggedIn() {
            return this.$store.state.isLoggedIn;
        }
    },
    methods: {
        setCurrentModal(modal) {
            this.$store.commit('setModal', { value: modal })
        },
        getProductsData() {
            this.axios.get("api/view-products").then(res => {
                if (res.data.status == 200) {
                    // console.log(res.data.products);
                    this.$store.commit('setProductItems', { value: res.data.products })
                }
            })
        },
        getSession() {
            this.sessionState = JSON.parse(sessionStorage.getItem('laravue_crud'));
            this.$store.commit('setIsLoggedIn', this.sessionState[0].isLoggedIn);
            this.$store.commit('setAccessType', this.sessionState[1].accessType);
            this.$store.commit('setUserID', this.sessionState[2].userID);
        }
    },
    watch: {
        updateWatcher(current, previous) {
            if(current !== previous) {
                this.getProductsData();
                this.componentKey += 1;
            }
        }
    },
    beforeMount() {
        this.getSession();
    },
    mounted() {
        if(!this.isLoggedIn) return;
        this.getProductsData();
    }
}
</script>

<style scoped>
th {
    font-size: .875rem !important;
}
</style>