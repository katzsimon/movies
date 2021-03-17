<template>
<div>
    <v-dialog max-width="780" v-model="dialog">
        <template v-slot:default="dialog">
            <v-card>
                <v-toolbar color="blue" dark class="text-h5">{{ movie.name }}</v-toolbar>
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
                                <th class="text-left whitespace-nowrap">
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
                                <td class="whitespace-nowrap">{{ item.cinema_name }}</td>
                                <td class="whitespace-nowrap">{{ item.theatre_name }}</td>
                                <td class="whitespace-nowrap">{{ item.datetime }}</td>
                                <td class="whitespace-nowrap">{{ item.seats_available }}</td>
                                <td>
                                    <v-btn
                                        color="blue"
                                        class="white--text"
                                        small
                                        :to="`/booking/screening/${item.id}`"
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
export default {
    name: "WatchMovie",
    data() {
        return {
            movies: '',
            dialog: false,
            screenings: {},
            movie: {},
            movieName: ''
        }
    },
    methods: {
        showScreeningsForMovie: function(id){
            axios.get(`api/screenings/${id}`)
                .then((res)=>{
                    this.screenings = res.data.data;
                    this.movie = res.data.movie;
                    this.dialog = true;

                })
                .catch((error)=>{
                    console.log('Error! ', error);
                    this.authStatus = 'Not authed';
                });
        }
    },
    mounted: function(){
        this.$eventHub.$on('selectedMovie', this.showScreeningsForMovie);
    },
    beforeDestroy() {
        this.$eventHub.$off('selectedMovie');
    },
}
</script>

<style scoped>

</style>
