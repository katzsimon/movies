<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <screening-form :errors="errors" :form="form" type="create" :ui="ui" :options="options"></screening-form>
        </div>
    </admin-layout>

</template>

<script>

import ScreeningForm from '@packages/cinema/resources/js/pages/admin/screenings/Form'
import ItemCreate from "@packagesBase/mixins/itemCreate";
export default {
    name: "Create",
    mixins: [ItemCreate],
    components: {
        ScreeningForm
    },
    props: {
        movie_options: Object,
        theatre_options: Object
    },
    computed: {
        options: function(){
            return {movie_options:this.movie_options, theatre_options:this.theatre_options};
        }
    },
}
</script>

<style scoped>

</style>
