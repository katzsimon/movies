<template>
    <div style="max-width:800px;margin:auto;">

        <h1 class="text-h3 mb-6">Upcoming Movies</h1>


        <div class="d-flex justify-center">
        <v-progress-circular v-if="!movies.length"
            indeterminate
            color="blue"
        ></v-progress-circular>
        </div>


            <v-card v-for="movie in movies" :key="movie.id" class="mb-6" >
                <v-img
                    :src="'https://picsum.photos/640/480?'+movie.id"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200"
                >
                    <v-card-title v-text="movie.name" style="font-size:2rem;" class="mx-2"></v-card-title>
                </v-img>
                <v-card-text class="pa-6">
                    <div class="my-2">
                        <strong>Rating: </strong>

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" v-for="rating in movie.rating" style="width:1rem;height:1rem;">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    </div>
                    <div class="my-2">
                        <strong>Runtime: </strong> {{ movie.runtime }} minutes
                    </div>
                    <div class="my-2">
                        <strong>Starring: </strong> {{ movie.starring }}
                    </div>
                    <div class="my-2">
                        <strong>Description:</strong><br>
                        {{ movie.description }}
                    </div>

                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions class="pa-6">
                    <v-btn color="blue" class="white--text" @click="showScreeningsForMovie(movie.id, movie.name)">
                        Where can I watch?
                    </v-btn>

                    <v-spacer></v-spacer>

                </v-card-actions>
            </v-card>


        <v-dialog max-width="780" v-model="dialog">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="blue" dark class="text-h5">{{ bookingMovieName }}</v-toolbar>
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
                                        <v-btn v-if="$store.getters.isLoggedIn"
                                            color="blue"
                                            class="white--text"
                                            small
                                            @click="book(item.id)"
                                        >Book</v-btn>

                                        <v-btn v-if="$store.getters.notLoggedIn"
                                            color="blue"
                                            class="white--text"
                                            small
                                        >Login To Book</v-btn>
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
import { mapGetters } from 'vuex'

export default {
    name: "UpcomingMovies",
    data() {
        return {
            test:'',
            movies: {},
            dialog: false,
            screenings: {},
            bookingMovieName: '',
            movie: {title:'Movie Title',  starring:'Starring', runtime:'Run Time', rating:'Rating', description:'Description'}
        }
    },
    computed: {
        ...mapGetters(['auth']),
    },
    metaInfo: {
        // title will be injected into parent titleTemplate
        title: 'Upcoming Movies'
    },
    methods: {
        showScreeningsForMovie: function(id, name){

            console.log('id: ', id);
            console.log('name: ', name);

            axios.get(`api/movie-screenings/${id}`)
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    console.log('Movie Screening Result: ', res.data.data);
                    this.screenings = res.data.data;
                    this.bookingMovieName = name;
                    //this.movie = res.data.data;

                    this.dialog = true;
                    //console.log('screenings: ', this.screenings.data);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });

        },
        book: function(id){
            this.$router.push({name:'booking', params:{screening:id}});
        },
        login: function(){

        }
    },
    mounted: function(){

            axios.get('api/upcoming-movies')
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    console.log('Result UPcoming Movies: ', res);
                    this.movies = res.data.data.items;
                    console.log('this.movies: ', this.movies);
                    //console.log('movies: ', this.screenings.data);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });



        /*
        axios.get('api/testapi', this.registerForm)
            .then((res)=>{
                if (res.status===200) this.test = res.data;
                console.log('Result: ', res);
            })
            .catch((error)=>{
                console.log('Error! ', error);
            });
        */
        /*
        axios.get('/sanctum/csrf-cookie').then(response => {

        });

         */
    }
}
</script>

<style scoped>
.v-card__title {
    text-shadow: 0px 3px 5px rgba(0, 0, 0, 0.4);
}
</style>
