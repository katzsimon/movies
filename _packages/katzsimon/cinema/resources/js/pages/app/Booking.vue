<template>
    <div>
        <app-heading>Make a Booking</app-heading>

        <v-form @submit.prevent="onSubmitBooking">

            <div id="selectMovie">
            <v-select
                v-model="movieId"
                :items="movies"
                label="Select The Movie"
                @input="setMovie(movieId)"
                :error-messages="this.errors.movie_id"
                outlined
                name="movie_id"
            ></v-select>
            </div>

            <v-select
                v-model="screeningId"
                :items="screenings"
                label="Select The Screening"
                outlined
                input="loadScreeningDetails(screeningId)"
                @input="setScreening(screeningId)"
                :error-messages="this.errors.screening_id"
                name="screening_id"
            ></v-select>


            <v-select
                v-model="seatsToBook"
                :items="seats"
                label="Number Of Seats To Book"
                :error-messages="this.errors.seats"
                outlined
                name="seats"
            ></v-select>



            <v-btn
                color="primary"
                type="submit"
                :loading="buttonLoading"
                @click="buttonLoading = true"
            >
                Book Now
            </v-btn>



        </v-form>


        <v-dialog width="500" v-model="dialog">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar :color="dialogColor" dark class="text-h5">Reservation</v-toolbar>
                    <v-card-text class="pa-6">

                        <div class="text-subtitle-1 mb-3"><strong>{{ bookingMessage }}</strong></div>

                        <div class="text-subtitle-1" v-if="bookingReference">Booking Reference: <strong>{{ bookingReference }}</strong></div>

                    </v-card-text>
                    <v-card-actions class="justify-end">
                        <v-btn
                            text
                            @click="dialog.value = false"
                        >Close</v-btn>
                        <v-btn
                            :color="dialogColor"
                            class="white--text"
                            @click="onBooked"
                        >OK</v-btn>
                    </v-card-actions>
                </v-card>
            </template>
        </v-dialog>

    </div>
</template>
<script>
import AppHeading from "@packagesBase/components/AppHeading";
export default {
    name: "Booking",
    components: {AppHeading},
    data() {
        return {
            errors: [],
            buttonLoading: false,
            screening: {},
            dialog: false,
            movieId:'',
            screeningId:'',
            reference:'',
            movies:[],
            seatsToBook:'',
            screenings:[],
            seats:[],
            booking:{},
            bookingStatus:'',
            bookingMessage:'',
            bookingReference:''
        }
    },
    props: {
    },
    metaInfo: {
        title: 'Book a Movie'
    },
    computed: {
        initScreeningId: function(){
            // The Screening ID when page loads
            let screening = this.$route.params.screening;
            if (typeof screening === 'undefined') {
                screening = 0;
            }
            return parseInt(screening);
        },
        initMovieId: function(){
            // The Movie ID when page loads
            let movie = this.$route.params.movie;
            if (typeof movie === 'undefined') {
                movie = 0;
            }
            return parseInt(movie);
        },
        dialogColor: function(){
            // Make the confirmation dialog red if there is an error when making the booking
            if (this.bookingStatus==='error') return 'red';
            return 'primary';
        },
    },
    methods: {
        onSubmitBooking() {
            // Make the Booking
            this.errors = [];
            axios.post(`api/booking`, {movie_id:this.movieId, screening_id:this.screeningId, seats:this.seatsToBook})
                .then((res)=>{
                    this.bookingStatus = res.data.status;
                    this.bookingMessage = res.data.message;
                    this.bookingReference = res.data.reference;
                    this.dialog = true;
                    this.buttonLoading = false;
                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.errors = error.response.data.errors;
                    this.buttonLoading = false;
                });
        },
        onBooked: function(){
            // Handler after the Booking confirmation dialog has been showed
            this.dialog = false;
            this.$router.push({name: 'account'});
        },
        setMovie(){
            // Change the page URL to reflect setting the Movie
            this.screenings = [];
            this.seats = [];
            this.$router.push({name:'booking-movie', params:{movie: this.movieId}});
            this.init();
        },
        setScreening(){
            // Change the page URL to reflect setting the Show
            this.seats = [];
            this.seatsToBook = '';
            this.$router.push({name:'booking-screening', params:{screening: this.screeningId}});
            this.init();
        },
        prepareOptions: function(input){
            // Convert the select options from the response so they can be used with the select elements
            let output = [];
            output.push({value:'', text:''});
            Object.keys(input).forEach(function (key) {
                var value = input[key];
                if (value!=='') output.push({value:key, text:value});
            });
            return output;
        },
        loadBookingDetails: function() {
            // Load Booking details, without a specified Movie or Screening
            axios.get(`api/booking`)
                .then((res)=>{
                    this.movies = this.prepareOptions(res.data.movie_options);
                    this.movieId = res.data.movie_id.toString();
                    this.screenings = this.prepareOptions(res.data.screening_options);
                    this.screeningId = res.data.screening_id.toString();
                    this.seats = this.prepareOptions(res.data.seat_options);
                })
                .catch((error)=>{
                    console.log('Error! ', error);
                });
        },
        loadBookingScreeningDetails: function(id) {
            // Load the Booking details with a specified Screening
            axios.get(`api/booking/screening/${id}`)
                .then((res)=>{
                    this.movies = this.prepareOptions(res.data.movie_options);
                    this.movieId = res.data.movie_id.toString();
                    this.screenings = this.prepareOptions(res.data.screening_options);
                    this.screeningId = res.data.screening_id.toString();
                    this.seats = this.prepareOptions(res.data.seat_options);
                })
                .catch((error)=>{
                    console.log('Error! ', error);
                });
        },
        loadBookingMovieDetails: function(id) {
            // Load the Booking details with a specified Movie
            axios.get(`api/booking/movie/${id}`)
                .then((res)=>{
                    this.movies = this.prepareOptions(res.data.movie_options);
                    this.movieId = res.data.movie_id.toString();
                    this.screenings = this.prepareOptions(res.data.screening_options);
                    this.screeningId = res.data.screening_id.toString();
                })
                .catch((error)=>{
                    console.log('Error! ', error);
                });
        },
        init: function(){

            // Determine which details to load, depending on whether a movie and/or screening has been selected
            if (this.initScreeningId===0 && this.initMovieId===0) {
                this.movies = [];
                this.screenings = [];
                this.seats = [];
                this.loadBookingDetails();
            } else if (this.initScreeningId>0 && this.initMovieId===0) {
                this.loadBookingScreeningDetails(this.initScreeningId);
            } else if (this.initScreeningId===0 && this.initMovieId>0) {
                this.loadBookingMovieDetails(this.initMovieId);
            }

        }
    },
    watch: {
        $route(to, from) {
            // Reload the page when the query parameters change
            this.init();
        }
    },
    mounted: function(){
        this.init();
    }
}
</script>

<style scoped>
</style>
