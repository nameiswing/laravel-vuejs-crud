import { createRouter, createWebHistory } from "vue-router";
import Login from "../views/Login.vue";

const routes = [
  {
    path: "/",
    name: "Login",
    component: Login,
  },
  {
    path: "/products",
    name: "Products",
    component: () => import("../views/Products.vue"),
  },
  {
    path: "/create-account",
    name: "Create Account",
    component: () => import("../views/CreateAccount.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
