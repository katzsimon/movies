<template>
    <admin-layout :title="'Update '+ui.name" :breadcrumbs="breadcrumbs">
        <div class="box">
            <booking-form :errors="errors" :form="form" type="edit" :ui="ui" :options="options"></booking-form>
        </div>
    </admin-layout>
</template>

<script>

import itemEdit from "@packagesBase/mixins/itemEdit";
import BookingForm from "@packages/cinema/resources/js/pages/admin/bookings/Form";

export default {
    name: "Edit",
    mixins: [itemEdit],
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
