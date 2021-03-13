<template>
    <admin-layout :title="'Update '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <movie-form :errors="errors" :form="form" type="edit" :ui="ui"></movie-form>
        </div>
    </admin-layout>
</template>

<script>

import itemEdit from "@packagesBase/mixins/itemEdit";
import MovieForm from '@packages/movie/resources/js/pages/admin/movies/Form'

export default {
    name: "Edit",
    mixins: [itemEdit],
    components: {
        MovieForm
    },
}
</script>

<style scoped>

</style>
