<template>
    <admin-layout title="Inertia Login">

        <div class="box">

            <form @submit.prevent="onLogin">

                <formfield-input label="Email Address: " name="email" v-model="form.email" :error="errors.email"></formfield-input>

                <formfield-input label="Password: " type="password" name="password" v-model="form.password" :error="errors.password"></formfield-input>

                <button type="submit" class="btn btn-primary">Login</button>

            </form>

        </div>


    </admin-layout>
</template>

<script>
import AdminLayout from '@packagesBase/templates/AdminLayout'
import FormfieldInput from "@packagesBase/components/FormfieldInput";

export default {
    name: "AdminLogin",
    props: {
        errors: Object,
    },
    components: {
        AdminLayout,
        FormfieldInput
    },
    data() {
        return {
            form: {
                email: null,
                password: null,
            },
        }
    },
    methods: {

        onLogin(event) {

            this.$inertia.post(this.$route(`admin.login.handle`, this.form));

        },

    },
    mounted: function(){
    },
}
</script>

<style scoped>

</style>
