<template>
    <template
        v-if="
            accessType === 'admin' ||
            (accessType === 'customer' && item.status === 'enabled')
        "
    >
        <td
            class="align-middle"
            :style="editable && 'background-color: #20c99733;'"
        >
            <div class="d-flex align-items-center">
                <span
                    class="d-inline-block rounded-pill fw-bold text-danger me-2"
                    v-if="accessType === 'customer'"
                    >{{ orderCount }}</span
                >
                <input type="text" :readonly="!editable" v-model="name" />
            </div>
        </td>
        <td
            class="align-middle description"
            :style="editable && 'background-color: #20c99733;'"
            @click.stop="showDescription"
        >
            <input type="text" v-model="description" :readonly="!editable" />
        </td>
        <td
            class="align-middle"
            :style="editable && 'background-color: #20c99733;'"
        >
            <div class="align-items-center d-flex">
                PHP<input type="number" v-model="price" :readonly="!editable" />
            </div>
        </td>
        <td
            v-if="accessType === 'admin'"
            class="align-middle qtty"
            :style="editable && 'background-color: #20c99733;'"
        >
            <input type="number" v-model="quantity" :readonly="!editable" />
        </td>
        <td
            class="py-2 align-middle text-center buttons"
            :style="editable && 'background-color: #20c99733;'"
        >
            <button
                class="btn btn-outline-success border-0"
                v-if="!editable && accessType === 'admin'"
                @click="startEdit"
                title="EDIT"
            >
                <i class="bi bi-pencil" style="font-size: 1.25rem"></i>
            </button>
            <button
                class="btn btn-outline-success border-0"
                v-if="editable && accessType === 'admin'"
                @click="editProduct(item.id)"
                title="SAVE CHANGES"
            >
                <i class="bi bi-check-lg" style="font-size: 1.25rem"></i>
            </button>
            <button
                v-if="accessType === 'admin'"
                type="button"
                :class="
                    item.status == 'enabled'
                        ? 'btn btn-outline-primary border-0'
                        : 'btn btn-outline-secondary border-0'
                "
                @click.prevent="toggleStatus(item.id)"
                style="font-size: 0.875rem"
                title="Toggle Status: ENABLED/DISABLED"
            >
                <i
                    class="bi bi-eye"
                    style="font-size: 1.25rem"
                    v-if="item.status == 'enabled'"
                ></i>
                <i
                    class="bi bi-eye-slash"
                    style="font-size: 1.25rem"
                    v-if="item.status == 'disabled'"
                ></i>
            </button>
            <button
                v-if="accessType === 'admin'"
                class="btn btn-outline-danger border-0"
                @click.prevent="deleteProduct(item.id)"
                title="DELETE"
            >
                <i class="bi bi-trash" style="font-size: 1.25rem"></i>
            </button>
            <button
                v-if="accessType === 'customer'"
                class="
                    btn btn-sm btn-outline-danger
                    border-0
                    d-flex
                    align-items-center
                    mx-auto
                    pe-3
                "
                title="ADD ITEM"
                @click="setOrders(orderItem)"
            >
                <i class="bi bi-plus" style="font-size: 1.25rem"></i
                >&nbsp;Add&nbsp;to&nbsp;Orders
            </button>
        </td>
    </template>
</template>

<script>
import { nanoid } from "nanoid";

export default {
    props: ["item"],
    data() {
        return {
            // itemData: this.item,
            editable: false,
            name: this.item.name,
            description: this.item.description,
            price: this.item.price,
            quantity: this.item.quantity,
            orderCount: 0,
        };
    },
    computed: {
        requestCounter() {
            return this.$store.productUpdateCount;
        },
        itemInfo() {
            return {
                name: this.name,
                description: this.description,
                price: this.price,
                quantity: this.quantity,
            };
        },
        accessType() {
            return this.$store.state.accessType;
        },
        orders() {
            return this.$store.state.orders;
        },
        userID() {
            return this.$store.state.userID;
        },
        orderItem() {
            return {
                id: this.item.id,
                name: this.item.name,
                price: this.item.price,
                order_id: "",
                user_id: this.userID,
            };
        },
    },
    methods: {
        localPrice(price) {
            return price.toLocaleString("en", { minimumFractionDigits: 2 });
        },
        generateUniqueID() {
            return (this.orderItem.order_id = nanoid().substr(0, 16));
        },
        showDescription() {
            if (this.editable) return;
            this.$swal("Description", this.description);
        },
        startEdit() {
            this.editable = !this.editable;
        },
        editProduct(id) {
            this.axios
                .put(`api/edit-product/${id}`, this.itemInfo)
                .then((res) => {
                    if (res.data.status == 200) {
                        this.$swal("Success", res.data.message);
                        this.$store.commit("incrementCounter");
                        this.startEdit();
                    } else {
                        this.$swal("Error.", "Unable to product product");
                    }
                });
        },
        toggleStatus(id) {
            this.axios
                .put(`api/toggle-product-status/${id}`, this.itemInfo)
                .then((res) => {
                    if (res.data.status == 200) {
                        this.$swal("Success", res.data.message);
                        this.$store.commit("incrementCounter");
                    } else {
                        this.$swal("Error.", "Unable to find product");
                    }
                });
        },
        deleteProduct(id) {
            this.axios.delete(`api/delete-product/${id}`).then((res) => {
                if (res.data.status == 200) {
                    this.$swal("Success", res.data.message);
                    this.$store.commit("incrementCounter");
                } else {
                    this.$swal("Error.", "Unable to delete product");
                }
            });
        },
        setOrders(item) {
            if (this.orderItem.order_id === "") this.generateUniqueID();
            this.$store.commit("setOrders", item);
            // console.log([...this.orders][0].price)
            this.orderCount += 1;
        },
        resetProductCount() {
            this.orderCount = 0;
        }
    },
    watch: {
        requestCounter(a,b) {
            if( a !== b ) {
                this.orderCount = 0;
            }
        }
    }
};
</script>

<style scoped>
input {
    border: 0;
    outline: 0;
    background: white;
    width: 100%;
    padding: 0.75rem 0.5rem;
    border-radius: 0.25rem;
    overflow: scroll;
}
input:focus {
    background-color: white;
}
input[readonly] {
    background: transparent;
}
td.description {
    word-wrap: break-word;
    word-break: break-all;
}
td.qtty {
    width: max-content;
}
td.buttons {
    white-space: nowrap;
}
</style>