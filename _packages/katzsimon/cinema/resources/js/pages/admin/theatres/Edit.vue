<template>
    <admin-layout :title="'Update '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <theatre-form :errors="errors" :form="form" type="edit" :ui="ui" :options="options" :parent="parent"></theatre-form>
        </div>
    </admin-layout>
</template>

<script>

import itemEdit from "@packagesBase/mixins/itemEdit";
import TheatreForm from '@packages/cinema/resources/js/pages/admin/theatres/Form'

export default {
    name: "Edit",
    mixins: [itemEdit],
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
