<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <cinema-form :errors="errors" :form="form" type="create" :ui="ui"></cinema-form>
        </div>
    </admin-layout>

</template>

<script>

import CinemaForm from '@packages/cinema/resources/js/pages/admin/cinemas/Form'
import ItemCreate from "@packagesBase/mixins/itemCreate";
export default {
    name: "Create",
    mixins: [ItemCreate],
    components: {
        CinemaForm
    },
}
</script>

<style scoped>

</style>
