<template>
    <div id="nav" class="navbar container-fluid bg-light shadow py-0 mb-4 d-flex align-items-center" style="height: 4rem">
        <h2 class="navbar-brand p-0 m-0">LaraVue CRUD App</h2>
        <!-- <router-link to="/">Login</router-link> -->
        <!-- <router-link to="/create-account">Create Account</router-link>| -->
        <!-- <router-link to="/products">Products</router-link> -->
        <button class="btn btn btn-outline-success" v-if="isLoggedIn" @click="setIsLoggedIn">Logout</button>
    </div>
</template>

<script>
export default {
    computed: {
        isLoggedIn() {
            return this.$store.state.isLoggedIn;
        },
        accessType () {
            return this.$store.state.accessType;
        }
    },
    methods: {
        setIsLoggedIn() {
            this.$store.commit('setIsLoggedIn', false);
            this.$store.commit('setAccessType', '');
            this.$store.commit('setUserID', '');
            this.$store.commit('clearOrders');
            this.createSession();
            this.$router.push('/');
        },
        createSession() {
            sessionStorage.setItem('laravue_crud', JSON.stringify([
                {isLoggedIn:this.isLoggedIn}, 
                {accessType:this.$store.state.accessType},
                {userID:this.$store.state.userID},
            ]));
        },
    },
}
</script>