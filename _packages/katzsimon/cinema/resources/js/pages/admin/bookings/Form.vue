<template>
    <div>

        <form @submit.prevent="onSubmit">

            <formfield-input label="ID: " name="id" v-model="form.id" readonly></formfield-input>

            <formfield-select label="User: " name="user_id" v-model="form.user_id" :error="errors.user_id" :options="options.user_options"></formfield-select>

            <formfield-select label="Screening: " name="screening_id" v-model="form.screening_id" :error="errors.screening_id" :options="options.screening_options"></formfield-select>

            <formfield-input label="Reference: " name="reference" v-model="form.reference" :error="errors.reference"></formfield-input>

            <formfield-input label="Seats: " name="seats" v-model="form.seats" :error="errors.seats"></formfield-input>


            <formfield-submit :type="type" cancelHref="/admin/bookings"></formfield-submit>

        </form>

    </div>
</template>

<script>
import itemForm from "@packagesBase/mixins/itemForm";

export default {
    name: "BookingForm",
    mixins: [itemForm],
    data() {
        return {
        }
    },
}
</script>

<style scoped>

</style>
