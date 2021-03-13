<template>
    <div>
        <app-heading>Cinemas</app-heading>
        <loading></loading>

        <div v-for="(details, cinema) in cinemas" :key="cinema">
            <v-card class="mb-6">
                <v-card-title class="d-flex flex-column align-start grey darken-3 white--text">
                    <strong class="text-h4">{{ cinema }}</strong>
                    <small class="text-subtitle-1">{{ details.location }}</small>
                </v-card-title>
                <v-card-text class="pt-4">
                    <div>
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Movies Screening Here</th>
                                <th class="w-40"></th>
                            </tr>
                            </thead>
                            <tr  v-for="(movie_name, movie_id) in details.movies" :key="movie_id">
                                <td>
                                    {{ movie_name }}
                                </td>
                                <td class="text-center">
                                    <v-btn color="blue" small class="white--text" :to="{ name:'booking-movie', params:{movie:movie_id} }">
                                        Book Now
                                    </v-btn>
                                </td>
                            </tr>
                        </table>
                    </div>
                </v-card-text>
            </v-card>
        </div>
    </div>
</template>
<script>
import AppHeading from "@packagesBase/components/AppHeading";
import Loading from "@packagesBase/components/Loading";
export default {
    name: "Cinemas",
    components: {AppHeading, Loading},
    data() {
        return {
            cinemas:[]
        }
    },
    mounted: function(){

        axios.get(`api/cinemas/`)
            .then((res)=>{
                this.cinemas = res.data.data;
                this.$eventHub.$emit('setPageLoaded', true);
            })
            .catch((error)=>{
                console.log('Error! ', error);
            });
    }
}
</script>

<style scoped>
</style>
