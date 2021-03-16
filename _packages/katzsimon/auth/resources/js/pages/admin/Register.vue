<template>
    <admin-layout title="Register">

        <div class="box">

            <form @submit.prevent="onRegister">

                <formfield-input label="Name: " name="name" v-model="form.name" :error="errors.name"></formfield-input>

                <formfield-input label="Email Address: " name="email" v-model="form.email" :error="errors.email"></formfield-input>

                <formfield-input label="Password: " type="password" name="password" v-model="form.password" :error="errors.password"></formfield-input>

                <formfield-input label="Confirm Password: " type="password" name="password_confirmation" v-model="form.password_confirmation" :error="errors.password_confirmation"></formfield-input>

                <button type="submit" class="btn btn-primary">Register</button>

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
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
        }
    },
    methods: {

        onRegister(event) {

            this.$inertia.post(this.$route(`admin.register.handle`, this.form));

        },

    },
    mounted: function(){
    },
}
</script>

<style scoped>

</style>
