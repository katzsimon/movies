<template>
    <div>
        <v-app-bar app color="primary accent-4" dark dense>

            <v-btn @click.stop="drawer = !drawer" text outlined style="min-width:32px;padding: 0 6px;">
            <svg class="block h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            </v-btn>



        <v-btn :to="{ name: 'cinemas' }" class="btn-nav-app ma-2" text plain outlined>Cinemas</v-btn>
        <v-btn :to="{ name: 'movies' }" class="btn-nav-app ma-2" text plain outlined>All Movies</v-btn>
        <v-btn :to="{ name: 'upcoming-movies' }" class="btn-nav-app ma-2" text plain outlined>Upcoming Movies</v-btn>

        <v-btn :to="{ name: 'upcoming-movies' }" class="btn-nav-app ma-2"  v-if="$store.getters.isLoggedIn" text plain outlined>Make a Booking</v-btn>

        <v-spacer></v-spacer>

        <v-btn :to="{ name:'login' }" class="btn-nav-app ma-2" v-if="$store.getters.notLoggedIn">Login</v-btn>
        <v-btn :to="{ name:'register' }" class="btn-nav-app ma-2" v-if="$store.getters.notLoggedIn">Register</v-btn>

        <v-btn :to="{ name:'account' }"  v-if="$store.getters.isLoggedIn" class="btn-nav-app ma-2">My Account</v-btn>
        <v-btn to="#"  v-if="$store.getters.isLoggedIn" class="btn-nav-app ma-2" @click="onLogout" id="btnLogout">Logout</v-btn>

        <v-btn :to="{ name:'home' }" text plain >
            <v-img
                max-height="36"
                max-width="36"
                src="/images/logo-white.svg"
            ></v-img>
        </v-btn>

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
                    <v-list-item-title>Movie Booking System</v-list-item-title>
                    <v-list-item-subtitle>Senior Assignment</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>


            <v-divider></v-divider>

            <v-list-item-group v-model="group" active-class="blue--text text--accent-4">

                <v-list-item :to="{ name: 'home' }" exact>
                    <v-list-item-title >Home</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'cinemas' }" exact>
                    <v-list-item-title >Cinemas</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'movies' }" exact>
                    <v-list-item-title >All Movie</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'upcoming-movies' }" exact>
                    <v-list-item-title >Upcoming Movies</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'booking' }" v-if="$store.getters.isLoggedIn" exact>
                    <v-list-item-title >Make a Booking</v-list-item-title>
                </v-list-item>





                <v-list-item :to="{ name: 'account' }" v-if="$store.getters.isLoggedIn"  class="mt-10">
                    <v-list-item-title >Account</v-list-item-title>
                </v-list-item>

                <v-list-item v-if="$store.getters.isLoggedIn" @click="onLogout">
                    <v-list-item-title >Logout</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'login' }" v-if="$store.getters.notLoggedIn" class="mt-10">
                    <v-list-item-title >Login</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'register' }" v-if="$store.getters.notLoggedIn">
                    <v-list-item-title >Register</v-list-item-title>
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
@media (max-width:1024px) {
    .btn-nav-app  {
       display:none;
    }
}
</style>
