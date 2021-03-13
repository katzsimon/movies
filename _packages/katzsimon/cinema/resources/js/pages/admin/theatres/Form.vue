<template>
    <div>

        <form @submit.prevent="onSubmit">

            <formfield-input label="ID: " name="id" v-model="form.id" readonly></formfield-input>

            <formfield-select label="Cinema: " name="title" v-model="form.cinema_id" :error="errors.cinema_id" :options="options.cinema_options"></formfield-select>

            <formfield-input label="Name: " name="name" v-model="form.name" :error="errors.name"></formfield-input>

            <formfield-input label="Max Seats: " type="number" name="intro" v-model="form.max_seats" :error="errors.max_seats"></formfield-input>


            <formfield-submit :type="type" :cancelHref="`/admin/cinemas/${parent.id}/theatres`"></formfield-submit>

        </form>

    </div>
</template>

<script>
import itemForm from "@packagesBase/mixins/itemForm";

export default {
    name: "CinemaForm",
    mixins: [itemForm],
    data() {
        return {
        }
    },
}
</script>

<style scoped>

</style>
