<template>
    <div class="card px-4 py-5 mx-auto shadow-sm mt-2" style="max-width:32rem">
        <h1 class="card-title mb-4 ms-3">User Login</h1>
        <div class="card-body ">
            <form class="mb-4" @submit.prevent="login">
                <div class="form-group mb-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control p-2" required v-model="email"/>
                </div>
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control p-2" required v-model="password"/>
                </div>
                <button class="btn btn-success w-100 mt-3" style="height: 3rem" >Login</button>
            </form>
            <p class="card-text">No account yet? <router-link to="/create-account">Click here</router-link> to sign up!</p>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: "",
                password: "",
                sessionState: '',
            }
        },
        computed: {
            loginData() {
                return { email_address: this.email, password: this.password }
            },
            isLoggedIn() {
                return this.$store.state.isLoggedIn;
            }
        },
        methods: {
            login() {
                this.axios.post(`api/login`, this.loginData).then( res => {
                    if(res.data.status == 200) {
                        // console.log(res.data.message);
                        this.$store.commit('setAccessType', res.data.access);
                        this.$store.commit('setUserID', res.data.userID);
                        this.$store.commit('setIsLoggedIn', true);
                        this.createSession();
                        this.$router.push('products');
                    }
                    else if(res.data.status === 404) {
                        this.$swal(res.data.message, 'Please sign up or try again.', 'error');
                    }
                    else {
                        console.error('Something went wrong. Unable to log in.')
                    }
                })
            },
            createSession() {
                sessionStorage.setItem('laravue_crud', JSON.stringify([
                    {isLoggedIn:this.isLoggedIn},
                    {accessType:this.$store.state.accessType},
                    {userID:this.$store.state.userID},
                ]));
                console.log(this.sessionState);
            },
        },
        // watch: {
        //     isLoggedIn(prev, current) {
        //         if( prev !== current ) return this.createSession();
        //     }
        // },
        // beforeMount() {
        //     this.getSession();
        // }
    }
</script>
