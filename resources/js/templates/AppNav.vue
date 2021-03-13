<template>
    <div>
        <v-app-bar app color="primary accent-4" dark dense>

        <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white pa-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </v-app-bar-nav-icon>

        <v-btn :to="{ name: 'home' }" class="ma-2" small exact>Home</v-btn>
        <v-btn :to="{ name: 'cinemas' }" class="ma-2" small exact>Cinemas</v-btn>
        <v-btn :to="{ name: 'movies' }" class="ma-2" small exact>All Movies</v-btn>
        <v-btn :to="{ name: 'upcoming-movies' }" class="ma-2" small exact>Upcoming Movies</v-btn>

        <v-btn :to="{ name: 'booking' }" class="ma-2" v-if="$store.getters.isLoggedIn" small>Make A Booking</v-btn>

        <v-spacer></v-spacer>

        <v-btn :to="{ name:'login' }" small class="mx-2" v-if="$store.getters.notLoggedIn">Login</v-btn>
        <v-btn :to="{ name:'register' }" class="mx-2" small v-if="$store.getters.notLoggedIn">Register</v-btn>

        <v-btn :to="{ name:'account' }" class="mx-2" small v-if="$store.getters.isLoggedIn">My Account</v-btn>
        <v-btn to="logout" small class="mx-2" v-if="$store.getters.isLoggedIn" @click="onLogout" id="btnLogout">Logout</v-btn>

        <v-img
            max-height="30"
            max-width="30"
            src="/images/logo-white.svg"
            class="ml-3"
        ></v-img>

    </v-app-bar>

    <v-navigation-drawer v-model="drawer" absolute temporary>
        <v-list nav dense>

            <v-list-item two-line>
                <v-list-item-avatar>
                    <v-img
                        max-height="60"
                        max-width="60"
                        src="/images/logo-black.svg"
                    ></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>Movie Booking App</v-list-item-title>
                    <v-list-item-subtitle>Senior Assignment</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>


            <v-divider></v-divider>

            <v-list-item-group v-model="group" active-class="blue--text text--accent-4">

                <v-list-item :to="{ name: 'home' }" exact>
                    <v-list-item-title >Home</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'cinemas' }" exact>
                    <v-list-item-title>Cinemas</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'movies' }" exact>
                    <v-list-item-title>All Movies</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'upcoming-movies' }" exact>
                    <v-list-item-title>Upcoming Movies</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'booking' }" v-if="$store.getters.isLoggedIn">
                    <v-list-item-title >Make A Booking</v-list-item-title>
                </v-list-item>


                <v-list-item v-if="$store.getters.isLoggedIn" :to="{ name: 'account' }"  class="mt-10" exact>
                    <v-list-item-title>My Account</v-list-item-title>
                </v-list-item>
                <v-list-item v-if="$store.getters.isLoggedIn" to="logout" exact @click="onLogout">
                    <v-list-item-title>Logout</v-list-item-title>
                </v-list-item>
                <v-list-item v-if="$store.getters.notLoggedIn" :to="{ name: 'login' }" class="mt-10" exact>
                    <v-list-item-title>Login</v-list-item-title>
                </v-list-item>
                <v-list-item v-if="$store.getters.notLoggedIn" :to="{ name: 'register' }" exact>
                    <v-list-item-title>Register</v-list-item-title>
                </v-list-item>

            </v-list-item-group>
        </v-list>
    </v-navigation-drawer>
    </div>
</template>

<script>
import logoutSanctum from "@packages/auth/resources/js/mixins/logoutSanctum";
export default {
    name: "AppNav",
    mixins: [logoutSanctum],
    data: () => ({
        drawer: false,
        group: null,
    }),
    props: {
    },
    watch: {
        group () {
            this.drawer = false
        },
    },
}
</script>

<style scoped>

</style>
