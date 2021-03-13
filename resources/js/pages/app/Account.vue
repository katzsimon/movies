<template>
    <div>
        <app-heading>My Account</app-heading>

        <loading></loading>

        <v-card class="mx-auto elevation-8 mb-12" outlined v-if="!bookingsFuture.length">
            <v-card-title class="headline primary white--text pa-6">
                <div class="d-flex flex-row justify-space-between" style="width:100%;">

                    <div>You Have No Upcoming Bookings Yet...</div>

                </div>
            </v-card-title>
            <v-card-text class="pt-4">
                <div class="mb-5 font-bold">Some useful links in the mean time:</div>
                <div class="mb-5"><v-btn to="/cinemas">Where can I watch a movie?</v-btn></div>
                <div class="mb-5"><v-btn to="/upcoming-movies">What movies are screening?</v-btn></div>
                <div><v-btn to="/booking">Make a new Booking</v-btn></div>
            </v-card-text>
        </v-card>

        <v-card class="mx-auto elevation-8 mb-12" outlined v-if="bookingsFuture.length">
            <v-card-title class="headline primary white--text pa-6">
                <div class="d-flex flex-row justify-space-between" style="width:100%;">
                    <div>Upcoming Bookings</div>
                    <div><v-btn @click="makeBooking">Make a new Booking</v-btn></div>
                </div>
            </v-card-title>
            <v-card-text class="pt-4">

                <div v-for="(booking, index) in bookingsFuture" :key="index" class="booking">

                    <div>Reference: <strong>{{ booking.reference }}</strong></div>
                    <div class="text-h6"><strong>{{ booking.screening_movie }}</strong></div>
                    <div v-html="booking.screening_theatre"></div>
                    <div><strong>{{ booking.screening_when }}</strong></div>

                    <v-btn small class="btn-cancel-booking" color="red lighten-4" v-if="booking.can_cancel" @click="onConfirmCancel(booking.id, booking.screening_movie)">
                        Cancel Booking
                    </v-btn>

                </div>

                <div v-if="!bookingsFuture">
                    You have no upcoming bookings
                </div>


            </v-card-text>
        </v-card>

        <v-card class="mx-auto elevation-8" outlined v-if="bookingsPast.length">
            <v-card-title class="headline grey lighten-2 pa-6">
                Past Bookings
            </v-card-title>
            <v-card-text class="pt-4">

                <div v-for="(booking, index) in bookingsPast" :key="index" class="booking">

                    <div>Reference: <strong>{{ booking.reference }}</strong></div>
                    <div class="text-h6"><strong>{{ booking.screening_movie }}</strong></div>
                    <div v-html="booking.screening_theatre"></div>
                    <div><strong>{{ booking.screening_when }}</strong></div>

                    <v-btn small class="btn-cancel-booking" color="red lighten-4" v-if="booking.can_cancel" @click="onConfirmCancel(booking.id, booking.screening_movie)">
                        Cancel Booking
                    </v-btn>

                </div>

            </v-card-text>
        </v-card>


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
export default {
    name: "Account",
    components:{
        AppHeading,
        Loading
    },
    data() {
        return {
            bookingsFuture:[],
            bookingsPast:[],
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
        this.loadBookings();
    },
    methods: {
        loadBookings: function() {

            axios.get(`api/bookings`)
                .then((res)=>{
                    this.bookingsFuture = res.data.bookingsFuture;
                    this.bookingsPast = res.data.bookingsPast;
                    this.$eventHub.$emit('setPageLoaded', true);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });
        },
        makeBooking: function(){
            this.$router.push({name:'booking'});
        },
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
                    //if (res.status===200) this.test = res.data;
                    console.log('Screening Cancel Bookings: ', res.data.data);
                    this.cancellationStatus = res.data.data.status;
                    this.cancellationMessage = res.data.data.message;
                    //this.bookingsFuture = res.data.bookingsFuture;
                    //this.loading = false;

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
