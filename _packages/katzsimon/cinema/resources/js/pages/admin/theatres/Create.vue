<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <theatre-form :errors="errors" :form="form" type="create" :ui="ui"></theatre-form>
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
}
</script>

<style scoped>

</style>
