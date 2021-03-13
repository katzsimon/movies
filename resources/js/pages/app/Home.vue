<template>
    <div>

        <loading></loading>


        <v-card  class="card" v-if="movies.length>0">
            <v-card-title class="headline grey darken-3 white--text" >
                Featured Movies
            </v-card-title>
            <v-card-text>
                <movie-details v-for="(movie, index) in movies" :key="index" :movie="movie" :index="index" :total="movies.length-1" class="movie-detail"></movie-details>
            </v-card-text>
        </v-card >
        <watch-movie></watch-movie>



        <div class="card mt-12" v-if="upcomingBookings.length>0">
            <div class="card-header">
                <div class="flex flex-row justify-between">
                    <div class="card-title flex-grow">Upcoming Bookings</div>
                    <div class="">
                        <v-btn small class="white--text" color="blue" to="/booking">
                            Make a New Booking
                        </v-btn>
                    </div>
                </div>
            </div>
            <div class="card-body">


                <div class="border border-gray-400 p-3 mb-3 relative" v-for="(item, index) in upcomingBookings" :key="index">
                    <div>Reference: <strong>{{ item['reference'] }}</strong></div>
                    <div class="text-h6"><strong>{{ item['screening_movie'] }}</strong></div>
                    <div>{{ item['screening_cinema'] }}, {{ item['screening_theatre'] }} ({{ item['seats'] }} seats)</div>
                    <div><strong>{{ item['screening_when'] }}</strong></div>


                    <v-btn small class="btn-cancel-booking" color="red lighten-4" v-if="item.can_cancel" @click="onConfirmCancel(item.id, item.screening_movie)">
                        Cancel Booking
                    </v-btn>

                </div>


            </div>
        </div>

        <v-dialog width="500" v-model="dialogCancel">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="red" dark class="text-h5">Cancellation</v-toolbar>
                    <v-card-text class="pa-6">

                        <div class="text-subtitle-1 mb-3">{{ cancelMovieName }}</div>

                        <div class="text-subtitle-1 mb-3"><strong>Are you sure you want to cancel this booking?</strong></div>

                        <div class="text-subtitle-1">You can only cancel when the booking is over an hour away</div>

                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            text
                            @click="dialogCancel=false"
                        >No</v-btn>
                        <v-btn
                            color="red"
                            class="white--text"
                            @click="onCancellation(cancelId)"
                        >Yes</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

        <v-dialog width="500" v-model="dialogCancelConfirmation">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="red" dark class="text-h5">Cancellation Confirmation</v-toolbar>
                    <v-card-text class="pa-6">

                        <div class="d-flex justify-center">
                            <v-progress-circular v-if="loading"
                                                 indeterminate
                                                 color="red"
                            ></v-progress-circular>
                        </div>

                        <div class="text-subtitle-1 mb-3"><strong>{{ cancellationStatus }}</strong></div>

                        <div class="text-subtitle-1">{{ cancellationMessage }}</div>

                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            text
                            @click="dialogCancelConfirmation=false"
                        >Close</v-btn>
                        <v-btn
                            color="red"
                            class="white--text"
                            @click="dialogCancelConfirmation=false;loadBookings"
                        >OK</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>


    </div>
</template>
<script>
import AppHeading from "@packagesBase/components/AppHeading";
import Loading from "@packagesBase/components/Loading";
import MovieDetails from "@packages/movie/resources/js/components/MovieDetails";
import WatchMovie from "@packages/cinema/resources/js/components/WatchMovie";
export default {
    name: "Home",
    components:{
        WatchMovie,
        MovieDetails,
        AppHeading,
        Loading
    },
    data() {
        return {
            movies: [],
            upcomingBookings: [],
            dialogCancel: false,
            dialogCancelConfirmation: false,
            cancelId: 0,
            cancelMovieName: '',
            cancellationStatus: '',
            cancellationMessage: '',
            loading: false
        }
    },
    mounted: function(){
        let url = `api/home`;
        if (this.$store.getters.isLoggedIn) url = 'api/home/user';
        axios.get(url)
            .then((res)=>{

                this.movies = res.data.movies;
                this.upcomingBookings = res.data.upcomingBookings;
                this.$eventHub.$emit('setPageLoaded', true);

            })
            .catch((error)=>{
                console.log('Error! ', error);
                this.authStatus = 'Not authed';
            });
    },
    methods: {
        onConfirmCancel: function(id, movie) {
            this.cancelId = id;
            this.cancelMovieName = movie;
            this.dialogCancel = true;
        },
        onCancellation: function(id) {
            this.dialogCancel = false;
            this.dialogCancelConfirmation = true;
            axios.post(`api/booking/cancel/${id}`)
                .then((res)=>{
                    this.cancellationStatus = res.data.data.status;
                    this.cancellationMessage = res.data.data.message;
                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });
        }
    }
}
</script>

<style scoped>
.booking {
    border:1px solid #ccc;
    padding:1rem;
    margin-bottom:1rem;
    position:relative;
}
.booking:last-child {
    margin-bottom:0;
}
.btn-cancel-booking {
    position:absolute;
    right:1rem;
    bottom:1rem;
}

@media (max-width:960px) {
    .btn-cancel-booking {
        position: relative;
        right:auto;
        bottom:auto;
        margin-top:0.5rem;
    }
}
</style>
