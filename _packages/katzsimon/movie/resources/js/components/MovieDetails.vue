<template>
    <div>
        <v-card :class="cls">
            <v-img
                :src="'https://picsum.photos/640/480?'+movie.id"
                class="white--text align-end"
                gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                height="200px"
            >
                <v-card-title v-text="movie.name" style="font-size:2rem;" class="mx-2"></v-card-title>
            </v-img>
            <v-card-text class="pa-6">
                <div class="my-2 d-flex flex-row">
                    <strong class="mr-2">Rating: </strong>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" v-for="rating in movie.rating" style="width:1rem;height:1rem;">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                </div>
                <div class="my-2">
                    <strong>Runtime: </strong> {{ movie.runtime }} minutes
                </div>
                <div class="my-2">
                    <strong>Genre: </strong> {{ movie.genre }}
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
                <v-btn color="blue" class="white--text" @click2="this.$eventHub.$emit('selectedMovie', movie.id)" @click="selectedMovie(movie.id)" v-if="movie.screening_count>0">
                    Where can I watch?
                </v-btn>
                <div v-if="movie.screening_count===0"><strong>There are no current screenings for this movie</strong></div>
            </v-card-actions>
        </v-card>

    </div>
</template>
<script>
export default {
    name: "MovieDetails",
    data() {
        return {
        }
    },
    props: {
        movie:{},
        index:Number,
        total:Number
    },
    computed: {
        cls: function(){
            let output = '';
            if (this.index===0) output += ' mt-6 ';
            if (this.index!==this.total) output += ' mb-6 ';
            return output;
        }
    },
    methods: {
        selectedMovie: function(id){
            console.log('selected movie', id);
            this.$eventHub.$emit('selectedMovie', id);
        }
    }
}
</script>

<style scoped>
</style>
