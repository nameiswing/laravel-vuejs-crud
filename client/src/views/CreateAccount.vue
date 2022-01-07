<template>
    <div class="card px-4 py-5 mx-auto shadow-sm mt-2" style="max-width:32rem">
        <h1 class="card-title mb-4 ms-3">Create Account</h1>
        <div class="card-body">
            <form class="mb-4"  @submit.prevent="createAccount">
                <div class="row">
                    <div class="col mb-4">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control p-2" required v-model="first_name"/>
                    </div>
                    <div class="col mb-4">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="last_name" class="form-control p-2" required v-model="last_name"/>
                    </div>
                </div>
                <div class="form-group mb-4">
                    <label for="email_address" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email_address" class="form-control p-2" required placeholder="youremail@gmail.com" v-model="email_address"/>
                </div>
                <div class="col mb-4">
                    <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" name="mobile_number" class="form-control p-2" required placeholder="+63 912-345-67890" v-model="mobile_number"/>
                </div>
                <div class="col mb-4">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" name="address" class="form-control p-2" required placeholder="House No., Street, City, ZIP" v-model="address"/>
                </div>
                <div class="form-group mb-4">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control p-2" required v-model="password"/>
                </div>
                <div class="form-check my-3" >
                    <input class="form-check-input" type="checkbox" name="status" id="status" v-model="checked">
                    <label for="status" class="form-check-label" >Admin Access</label>
                </div>
                <button class="btn btn-success w-100 mt-3" style="height: 3rem">Create</button>
            </form>
            <p class="card-text">
                Have an account?
                <router-link to="/">Click here</router-link> to log in!
            </p>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            first_name: '',
            last_name: '',
            email_address: '',
            mobile_number: '',
            address: '',
            checked: false,
            password: '',
        }
    },
    computed: {
        status() {
            return this.checked ? 'admin' : 'customer';
        },
        accountInfo() {
            return {
                first_name: this.first_name,
                last_name: this.last_name,
                email_address: this.email_address,
                mobile_number: this.mobile_number,
                address: this.address,
                status: this.status,
                password: this.password,
            }
        },
    },
    methods: {
        toggleStatus() {
            if(this.status === 'admin') return this.status === 'customer';
            if(this.status === 'customer') this.status === 'admin';
        },
        createAccount() {
            this.axios.post("api/user-create", this.accountInfo).then( res => {
                if(res.data.status == 200) {
                    this.$swal('Success', res.data.message);
                    this.first_name = '';
                    this.last_name = '';
                    this.email_address = '';
                    this.mobile_number = '';
                    this.address = '';
                    this.password = '';
                    this.$router.push('/');
                } 
                else if(res.data.status == 409) {
                    this.$swal('Error', res.data.message);
                }
                else {
                    this.$swal('Error', 'Unable to create account. Please try again.');
                }
            })
        }
    }
}
</script>
