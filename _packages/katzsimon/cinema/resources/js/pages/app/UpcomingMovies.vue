<template>
    <div>
        <app-heading>Upcoming Movies</app-heading>

        <loading></loading>

        <movie-details v-for="(movie, index) in movies" :key="movie.id" :movie="movie" :index="index" :total="movies.length-1"></movie-details>

        <watch-movie></watch-movie>
    </div>
</template>
<script>
import AppHeading from "@packagesBase/components/AppHeading";
import MovieDetails from "@packages/movie/resources/js/components/MovieDetails";
import Loading from "@packagesBase/components/Loading";
import WatchMovie from "@packages/cinema/resources/js/components/WatchMovie";

export default {
    name: "UpcomingMovies",
    components: {
        Loading,
        AppHeading,
        MovieDetails,
        WatchMovie
    },
    data() {
        return {
            movies: '',
            dialog: false,
            screenings: {},
            movie: {}
        }
    },

    mounted: function(){

        axios.get('api/upcoming-movies')
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
</style>
