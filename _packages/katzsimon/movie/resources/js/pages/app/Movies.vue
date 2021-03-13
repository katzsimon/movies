<template>
    <div>

        <app-heading>All Movies</app-heading>

        <loading></loading>

        <movie-details v-for="(movie, index) in movies" :key="movie.id" :movie="movie" :index="index" :total="movies.length-1"></movie-details>

        <watch-movie></watch-movie>

        <v-dialog max-width="760" v-model="dialog">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="blue" dark class="text-h5">{{ movie.title }}</v-toolbar>
                    <v-card-text class="pa-6">
                        <v-simple-table>
                            <template v-slot:default>
                                <thead>
                                <tr>
                                    <th class="text-left">
                                        Cinema
                                    </th>
                                    <th class="text-left">
                                        Theatre
                                    </th>
                                    <th class="text-left">
                                        When
                                    </th>
                                    <th class="text-left">
                                        Seats Available
                                    </th>
                                    <th>

                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    v-for="item in screenings"
                                    :key="item.id"
                                >
                                    <td>{{ item.cinema_name }}</td>
                                    <td>{{ item.theatre_name }}</td>
                                    <td>{{ item.datetime }}</td>
                                    <td>{{ item.seats_available }}</td>
                                    <td>
                                        <v-btn
                                            color="blue"
                                            class="white--text"
                                            small
                                            :to="{name:'booking'}"
                                        >Book</v-btn>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            text
                            @click="dialog.value = false"
                        >Close</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>
    </div>
</template>
<script>
import AppHeading from "@packagesBase/components/AppHeading";
import MovieDetails from "@packages/movie/resources/js/components/MovieDetails";
import WatchMovie from "@packages/cinema/resources/js/components/WatchMovie";
import Loading from "@packagesBase/components/Loading";

export default {
    name: "Movies",
    components: {
        AppHeading,
        MovieDetails,
        Loading,
        WatchMovie
    },
    data() {
        return {
            test:'',
            movies: '',
            dialog: false,
            screenings: {},
            movie: {title:'Movie Title',  starring:'Starring', runtime:'Run Time', rating:'Rating', description:'Description'}
        }
    },
    mounted: function(){
        axios.get('api/movies')
            .then((res)=>{
                this.movies = res.data.data;
                this.$eventHub.$emit('setPageLoaded', true);
            })
            .catch((error)=>{
                console.log('Error! ', error);
                this.authStatus = 'Not authed';
            });
    },

}
</script>

<style scoped>
.v-card__title {
    text-shadow: 0px 3px 5px rgba(0, 0, 0, 0.3);
}
</style>
