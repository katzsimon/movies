<template>
        <v-app>
            <app-nav></app-nav>
            <v-main>
                <v-container class="container">
                    <router-view />
                </v-container>
            </v-main>
        </v-app>
</template>

<script>
import toast from "@packagesBase/mixins/toast";
import AppNav from "@/templates/AppNav";


export default {
    name: "LayoutApp",
    components:{
        AppNav
    },


}
</script>

<style scoped>

.container {
    max-width:800px;
    margin:auto;
}
</style>
