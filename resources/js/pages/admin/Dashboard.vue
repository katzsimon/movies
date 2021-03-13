<template>
    <admin-layout title="Dashboard">

        <div class="box">

            <div class="card mb-6" v-if="bookings">
                <div class="card-header">
                    <div class="card-title">Upcoming Bookings</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-middle table-hover">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Where</th>
                            <th>Movie</th>
                            <th>When</th>
                            <th>Seats</th>
                            <th>Reference</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr v-for="(booking, index) in bookings" :key="index">
                            <td>{{ booking['user_name'] }}</td>
                            <td v-html="booking['screening_cinema_theatre']"></td>
                            <td>{{ booking['movie_name'] }}</td>
                            <td>{{ booking['screening_when'] }}</td>
                            <td>{{ booking['seats'] }}</td>
                            <td>{{ booking['reference'] }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>


            <div class="card">
                <div class="card-header">
                    <div class="card-title">Factories</div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-middle">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th class="w-60">&nbsp;</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Movie</td>
                            <td class="text-center">
                                <form  @submit.prevent="onFactoryMovies">
                                    <div class="flex2 flex-row2">
                                        <formfield-select name="numberMovie" v-model="formMovie.numberMovie" label="Number of Movies" :options="['', 1, 2, 3, 4, 5]"></formfield-select>
                                        <button type="submit" class="btn btn-primary w-full">Make Movies</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Screenings (with Cinemas, Theatres, Movies)</td>
                            <td class="text-center">
                                <form  @submit.prevent="onFactoryScreenings">
                                    <div class="flex2 flex-row2">
                                        <formfield-select name="numberScreening" v-model="formScreening.numberScreening" label="Number of Screenings" :options="['', 1, 2, 3, 4, 5]"></formfield-select>
                                        <formfield-select name="numberMovie" v-model="formScreening.numberMovie" label="Number of Movies" :options="['', 1, 2, 3, 4, 5]"></formfield-select>
                                        <button type="submit" class="btn btn-primary w-full">Make Screenings</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Bookings (with Cinema, Theatre, Movie, Screening)</td>
                            <td class="text-center">
                                <form  @submit.prevent="onFactoryBookings">
                                    <div class="flex2 flex-row2">
                                        <formfield-select name="numberBooking" v-model="formBooking.numberBooking" label="Number of Bookings" :options="['', 1, 2, 3, 4, 5]"></formfield-select>
                                        <formfield-select name="past" v-model="formBooking.past" label="Future or Past" :options="['', 'Past', 'Future']"></formfield-select>
                                        <button type="submit" class="btn btn-primary w-full">Make Bookings</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </admin-layout>
</template>

<script>
import AdminLayout from '@packagesBase/templates/AdminLayout'
import FormfieldSelect from "@packagesBase/components/FormfieldSelect";
export default {
    name: "AdminDashboard",
    props: {
        bookings: Array,
    },
    data() {
        return {
            formMovie:{numberMovie:''},
            formScreening:{numberScreening:'', numberMovie:''},
            formBooking:{numberBooking:'',past:''},
        }
    },
    components: {
        AdminLayout,
        FormfieldSelect
    },
    mounted: function() {
    },
    methods: {
        onFactoryMovies: function(){

            axios.post('/admin/factory/movies', this.formMovie)
                .then((res)=>{
                    this.$eventHub.$emit('toast', `Movie Factory created`, 'Success', 'success');
                })
                .catch((error)=>{
                    this.errors = error.response.data.errors;
                    console.log('Error! ', error);
                });

        },
        onFactoryScreenings: function(){

            axios.post('/admin/factory/screenings', this.formScreening)
                .then((res)=>{
                    this.$eventHub.$emit('toast', `Screening Factory created`, 'Success', 'success');
                })
                .catch((error)=>{
                    this.errors = error.response.data.errors;
                    console.log('Error! ', error);
                });

        },
        onFactoryBookings: function(){

            axios.post('/admin/factory/bookings', this.formBooking)
                .then((res)=>{
                    this.$eventHub.$emit('toast', `Booking Factory created`, 'Success', 'success');
                })
                .catch((error)=>{
                    this.errors = error.response.data.errors;
                    console.log('Error! ', error);
                });

        }
    }
}
</script>

<style scoped>

</style>
