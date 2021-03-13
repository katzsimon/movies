<template>
    <div>
            <v-card v-for="screening in screenings" :key="screening.id" class="mb-6" >
                <v-img
                    :src="'https://picsum.photos/640/480?'+screening.id"
                    class="white--text align-end"
                    gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                    height="200px"
                >
                    <v-card-title v-text="screening.movie_name" style="font-size:2rem;" class="mx-2"></v-card-title>
                </v-img>
                <div class="pa-6">
                    <div class="my-1"><strong>Where?</strong> {{ screening.theatre_name }}, {{ screening.cinema_name }}</div>
                    <div class="my-1"><strong>When?</strong> {{ screening.datetime }}</div>
                    <div class="my-1"><strong>Seats still available:</strong> {{ screening.seats_available }}</div>
                </div>
                <v-divider></v-divider>
                <v-card-actions class="pa-6">
                    <v-btn color="blue" class="white--text" v-if="$store.getters.isLoggedIn" >
                        Book Now
                    </v-btn>

                    <v-btn color="blue" outlined class="white--text" v-if="$store.getters.notLoggedIn" >
                        Book Now
                    </v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue" outlined class="" @click="showMovieDetails(screening.movie_id)">
                        View Movie Details {{ screening.movie_id }}
                    </v-btn>
                </v-card-actions>
            </v-card>


        <v-dialog max-width="600" v-model="dialog">
            <template v-slot:default="dialog">
                <v-card>
                    <v-toolbar color="blue" dark class="text-h5">{{ movie.title }}</v-toolbar>
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

export default {
    name: "Screenings",
    data() {
        return {
            screenings: '',
            dialog: false,
            movie: {title:'Movie Title',  starring:'Starring', runtime:'Run Time', rating:'Rating', description:'Description'}
        }
    },
    methods: {
        showMovieDetails: function(id){

            axios.get(`api/movies/${id}`)
                .then((res)=>{
                    //if (res.status===200) this.test = res.data;
                    //console.log('Movie Result: ', res);
                    this.movie = res.data.data;
                    this.dialog = true;
                    //console.log('screenings: ', this.screenings.data);

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });

        }
    },
    mounted: function(){

        axios.get('api/upcoming-screenings')
            .then((res)=>{
                //if (res.status===200) this.test = res.data;
                console.log('Result: ', res);
                this.screenings = res.data.data;
                console.log('screenings: ', this.screenings.data);

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
    text-shadow: 0px 3px 5px rgba(0, 0, 0, 0.3);
}
</style>
