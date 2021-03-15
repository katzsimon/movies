<template>

    <admin-layout :title="'Create a New '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <booking-form :errors="errors" :form="form" type="create" :ui="ui" :options="options"></booking-form>
        </div>
    </admin-layout>

</template>

<script>
import BookingForm from '@packages/cinema/resources/js/pages/admin/bookings/Form'
import ItemCreate from "@packagesBase/mixins/itemCreate"

export default {
    name: "Create",
    mixins: [ItemCreate],
    components: {
        BookingForm
    },
    props: {
        user_options: Object,
        screening_options: Object,
    },
    computed: {
        options: function(){
            return {user_options:this.user_options,screening_options:this.screening_options};
        }
    },
}
</script>

<style scoped>

</style>
