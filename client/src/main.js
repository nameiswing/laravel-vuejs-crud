import { createApp } from "vue";
import { createStore } from "vuex";
import App from "./App.vue";
import router from "./router";
import "./assets/styles/global.css";
import axios from "axios";
import VueAxios from "vue-axios";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

axios.defaults.baseURL = "http://localhost:8000";

const store = createStore({
    state: {
        products: [],
        orders: [],
        currentModal: "home",
        productUpdateCount: 0,
        accessType: "",
        isLoggedIn: false,
        userID: '',
        tempOrderItem: null,
        tempProductItem: null,
    },
    mutations: {
        setModal (state, payload) {
            state.currentModal = payload.value
        },
        setProductItems (state, payload) {
            state.products = payload.value
        },
        incrementCounter (state) {
            state.productUpdateCount += 1;
        },
        setAccessType (state, payload) {
            state.accessType = payload
        },
        setIsLoggedIn (state, payload) {
            state.isLoggedIn = payload
        },
        setOrders (state, payload) {
            this.tempOrderItem = state.orders.find( item => item.id === payload.id);
            this.tempProductItem = state.products.find( item => item.id === payload.id);
            if(this.tempOrderItem) {
                state.orders.find( item => item.id === payload.id).price = this.tempOrderItem.price + this.tempProductItem.price;
            } else {
                state.orders.push(payload)
            }
        },
        clearOrders(state) {
            state.orders = [];
        },
        setUserID (state, payload) {
            state.userID = payload
        }
    },
})

const app = createApp(App);
app.use(store);
app.use(router);
app.use(VueAxios, axios);
app.use(VueSweetalert2);
app.mount("#app");
