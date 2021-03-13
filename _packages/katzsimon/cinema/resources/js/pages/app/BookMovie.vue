<template title="test title">
    <div>
        <app-heading>Make a Movie Reservation</app-heading>

        <v-form @submit.prevent="onSubmitBooking">

            <v-select
                v-model="movieId"
                :items="movies"
                label="Select The Movie"
                @input="loadMovieDetails(movieId)"
                outlined
            ></v-select>

            <v-select
                v-model="screeningId"
                :items="screenings"
                label="Select The Screening"
                outlined
                @input="loadScreeningDetails(screeningId)"
                :error-messages="this.errors.screening_id"
            ></v-select>


            <v-select
                v-model="seatsToBook"
                :items="seats"
                label="Number Of Seats To Book"
                :error-messages="this.errors.seats"
                outlined
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
    name: "BookMovie",
    components: {AppHeading},
    data() {
        return {
            form: {
                email: '',
                password: ''
            },
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
            test:[{value:1, text:'One'}, 'Two', 'Three'],
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
            return this.$route.params.screening;
        },
        dialogColor: function(){
          if (this.bookingStatus==='error') return 'red';
          return 'primary';
        },
        seats: function(){
            let output = [];
            for (let i=1; i<=this.screening.seats_available; i++) {
                output.push(i);
            }
            return output;
        }
    },
    methods: {
        onSubmitBooking() {

            this.errors = [];

            axios.post(`api/booking`, {screening_id:this.screeningId, seats:this.seatsToBook})
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    console.log('Screening onSubmit: ', res.data);

                    this.bookingStatus = res.data.status;
                    this.bookingMessage = res.data.message;
                    this.bookingReference = res.data.reference;
                    //this.booking = res.data.data.booking;

                    this.dialog = true;
                    //this.movies = res.data.data.movies;
                    //this.screenings = res.data.data.screenings;

                    //this.dialog = true;
                    //console.log('screenings: ', this.screenings.data);

                    this.buttonLoading = false;

                })
                .catch((error)=>{

                    console.log('Error! ', error);
                    console.log('data: ', error.response.data);
                    this.errors = error.response.data.errors;
                    this.buttonLoading = false;
                });
            console.log('submit booking');
        },
        loadMovieDetails(id) {
            //console.log('movieId: ', this.movieId);
            this.seatsToBook = '';

            axios.get(`api/booking/movie/${id}`)
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    console.log('Screening loadMovieDetails: ', res.data.data);
                    this.movies = res.data.data.movies;
                    this.screenings = res.data.data.screenings;

                    //this.dialog = true;
                    //console.log('screenings: ', this.screenings.data);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                });
        },
        loadScreeningDetails(id) {
            let screeningId = id;
            this.seatsToBook = '';
            if (typeof screeningId==='undefined') screeningId = '';
            axios.get(`api/booking/${screeningId}`)
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    console.log('Screening loadScreeningDetails: ', res.data.data);
                    this.screening = res.data.data.item;
                    this.movieId = this.screening.movie_id;
                    this.screeningId = this.screening.id;
                    //this.screenings = res.data.data;
                    //this.bookingMovieName = name;
                    this.movies = res.data.data.movies;
                    this.screenings = res.data.data.screenings;

                    //this.dialog = true;
                    //console.log('screenings: ', this.screenings.data);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });
        },
        onBooked: function(){
            this.dialog = false;
            this.$router.push({name: 'account'});
        }
    },
    mounted: function(){
        this.loadScreeningDetails(this.initScreeningId);
    }
}
</script>

<style scoped>

</style>

