<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <theatre-form :errors="errors" :form="form" type="create" :ui="ui" :options="options"  :parent="parent"></theatre-form>
        </div>
    </admin-layout>

</template>

<script>

import TheatreForm from '@packages/cinema/resources/js/pages/admin/theatres/Form'
import ItemCreate from "@packagesBase/mixins/itemCreate";
export default {
    name: "Create",
    mixins: [ItemCreate],
    components: {
        TheatreForm
    },
    props: {
        cinema_options: Object,
        parent: Object
    },
    computed: {
        options: function(){
            return {cinema_options:this.cinema_options};
        }
    },
}
</script>

<style scoped>

</style>
