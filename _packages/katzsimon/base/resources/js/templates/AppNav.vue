<template>
    <div>
        <v-app-bar app color="primary accent-4" dark dense>

        <v-app-bar-nav-icon @click.stop="drawer = !drawer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white pa-2">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </v-app-bar-nav-icon>


        <v-btn :to="{ name: 'home' }" class="ma-2 d-none d-md-flex" text plain outlined exact>Home</v-btn>

        <v-btn :to="{ name: 'dashboard' }" class="ma-2" v-if="$store.getters.isLoggedIn" text plain outlined>Dashboard</v-btn>
        <v-btn :to="{ name: 'screenings' }" class="ma-2" text plain outlined>Screenings</v-btn>
        <v-btn :to="{ name: 'movies' }" class="ma-2" text plain outlined>Movies</v-btn>

        <v-btn :to="{ name: 'upcoming-movies' }" class="ma-2" text plain outlined>Upcoming Movies</v-btn>

        <v-spacer></v-spacer>

        <v-btn :to="{ name:'login' }" class="ma-2" v-if="$store.getters.notLoggedIn">Login</v-btn>
        <v-btn :to="{ name:'register' }" class="ma-2" v-if="$store.getters.notLoggedIn">Register</v-btn>

        <v-btn :to="{ name:'account' }"  v-if="$store.getters.isLoggedIn" class="ma-2">My Account</v-btn>
        <v-btn to="#"  v-if="$store.getters.isLoggedIn" class="ma-2" @click="onLogout" id="btnLogout">Logout</v-btn>

        <v-img
            max-height="50"
            max-width="50"
            src="/images/payfast-logo.svg"
        ></v-img>

    </v-app-bar>

    <v-navigation-drawer
        v-model="drawer"
        absolute
        temporary
    >
        <v-list
            nav
            dense
        >


            <v-list-item two-line>
                <v-list-item-avatar>
                    <v-img
                        max-height="60"
                        max-width="60"
                        src="/images/payfast-logo.svg"
                    ></v-img>
                </v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title>Movie Booking App</v-list-item-title>
                    <v-list-item-subtitle>Senior Assignment</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>


            <v-divider></v-divider>

            <v-list-item-group
                v-model="group"
                active-class="blue--text text--accent-4"
            >

                <v-list-item :to="{ name: 'home' }" v-if="$store.getters.isLoggedIn" exact>
                    <v-list-item-title >Home</v-list-item-title>
                </v-list-item>

                <v-list-item :to="{ name: 'dashboard' }" v-if="$store.getters.isLoggedIn">
                    <v-list-item-title >Dashboard</v-list-item-title>
                </v-list-item>



                <v-list-item>
                    <v-btn :to="{ name: 'screenings' }" class="ma-2" v-if="$store.getters.isLoggedIn">Screenings</v-btn>

                </v-list-item>

                <v-list-item>
                    <v-list-item-title>Fizz</v-list-item-title>
                </v-list-item>

                <v-list-item>
                    <v-list-item-title>Buzz</v-list-item-title>
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
