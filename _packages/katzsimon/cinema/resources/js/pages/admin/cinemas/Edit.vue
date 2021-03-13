<template>
    <admin-layout :title="'Update '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <cinema-form :errors="errors" :form="form" type="edit" :ui="ui"></cinema-form>
        </div>
    </admin-layout>
</template>

<script>

import itemEdit from "@packagesBase/mixins/itemEdit";
import CinemaForm from '@packages/cinema/resources/js/pages/admin/cinemas/Form'

export default {
    name: "Edit",
    mixins: [itemEdit],
    components: {
        CinemaForm
    },
}
</script>

<style scoped>

</style>
