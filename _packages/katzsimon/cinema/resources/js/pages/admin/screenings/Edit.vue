<template>
    <admin-layout :title="'Update '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <screening-form :errors="errors" :form="form" type="edit" :ui="ui" :options="options"></screening-form>
        </div>
    </admin-layout>
</template>

<script>

import itemEdit from "@packagesBase/mixins/itemEdit";
import ScreeningForm from '@packages/cinema/resources/js/pages/admin/screenings/Form'

export default {
    name: "Edit",
    mixins: [itemEdit],
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
