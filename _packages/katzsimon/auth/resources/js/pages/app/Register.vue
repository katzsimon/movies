<template>
    <div>
        <v-card
            class="mx-auto elevation-8"
            max-width="344"
            outlined
        >
            <v-card-title class="headline primary white--text pa-6">
                Register
            </v-card-title>

            <div class="pa-6">

            <v-form @submit.prevent="onRegister">

                <v-text-field
                    v-model="form.name"
                    label="Name"
                    required
                    outlined
                    class=""
                    name="name"
                    :error-messages="this.errors.name"
                ></v-text-field>

                <v-text-field
                    v-model="form.email"
                    label="E-mail"
                    required
                    outlined
                    class=""
                    name="email"
                    :error-messages="this.errors.email"
                ></v-text-field>

                <v-text-field
                    v-model="form.password"
                    type="password"
                    label="Password"
                    required
                    outlined
                    class=""
                    name="password"
                    :error-messages="this.errors.password"
                ></v-text-field>

                <v-text-field
                    v-model="form.password_confirmation"
                    type="password"
                    label="Confirm Password"
                    required
                    outlined
                    class=""
                    name="password_confirmation"
                    :error-messages="this.errors.password_confirmation"
                ></v-text-field>

                <div class="d-flex justify-end">
                <v-btn
                    color="primary"
                    type="submit"
                >
                    Register
                </v-btn>
                </div>



            </v-form>



            </div>
        </v-card>
    </div>
</template>

<script>
export default {
    name: "Register",
    components: {
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            errors: [],
        }
    },
    methods: {
        onRegister(event) {
            event.preventDefault();
            axios.post('/api/register', this.form)
                .then((res)=>{

                    let userId = parseInt(res.data.user.id);
                    if (userId>0) {
                        this.$store.commit('login', res.data.token, res.data.user);
                        this.$router.push({name: 'account'});
                    }

                })
                .catch((error)=>{
                    this.errors = error.response.data.errors;
                    console.log('Error! ', error);
                });
        }
    },


}
</script>

<style scoped>

</style>
