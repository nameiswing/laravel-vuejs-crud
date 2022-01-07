<template>
        <div>
            <Navbar />
            <div class="container-md p-0">
                <router-view />
            </div>
            <AddProduct v-if="currentModal === 'add-product'" />
            <ViewOrder v-if="currentModal === 'view-order'" />
        </div>
</template>

<script>
import AddProduct from "@/components/AddProduct";
import ViewOrder from "@/components/ViewOrder";
import Navbar from "@/components/Navbar";

export default {
    components: {
        AddProduct,
        ViewOrder,
        Navbar
    },
    computed: {
        currentModal() {
            return this.$store.state.currentModal
        }
    }
}
</script>