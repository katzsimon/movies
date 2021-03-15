<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <movie-form :errors="errors" :form="form" type="create" :ui="ui"></movie-form>
        </div>
    </admin-layout>

</template>

<script>

import MovieForm from '@packages/movie/resources/js/pages/admin/movies/Form'
import ItemCreate from "@packagesBase/mixins/itemCreate";
export default {
    name: "Create",
    mixins: [ItemCreate],
    components: {
        MovieForm
    },
}
</script>

<style scoped>

</style>
