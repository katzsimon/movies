<template>
    <div>
        <v-card
            class="mx-auto elevation-8"
            max-width="344"
            outlined
        >
            <v-card-title class="headline primary white--text pa-6">
                Login
            </v-card-title>

            <div class="pa-6">

            <v-form @submit.prevent="onLogin">

                <v-text-field
                    v-model="form.email"
                    label="E-mail"
                    required
                    outlined
                    name="email"
                    class=""
                    :error-messages="this.errors.email"
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    type="password"
                    label="Password"
                    required
                    outlined
                    name="password"
                    class=""
                    :error-messages="this.errors.password"
                ></v-text-field>

                <div class="d-flex justify-end">
                <v-btn
                    color="primary"
                    type="submit"
                    id="btnLogin"
                    dusk="btnDusk"
                >
                    Login
                </v-btn>
                </div>



            </v-form>

            </div>
        </v-card>
    </div>
</template>

<script>
import FormfieldInput from "@packagesBase/components/FormfieldInput";

export default {
    name: "Login",
    components: {
        FormfieldInput,
    },
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
            errors: [],
        }
    },
    methods: {
        onLogin(event) {
            event.preventDefault();
            axios.post('/api/login', this.form)
                .then((res)=>{
                    this.$store.commit('login', res.data.token, res.data.user);
                    this.$router.push({name:'account'});
                })
                .catch((error)=>{
                    this.errors = error.response.data.errors;
                    console.log('Error! ', error);
                });
        },
    },
}
</script>

<style scoped>

</style>
