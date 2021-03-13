<template>
    <div>

        <form @submit.prevent="onSubmit">

            <formfield-input label="ID: " name="id" v-model="form.id" readonly></formfield-input>

            <formfield-input label="Date Time: " name="datetime" v-model="form.datetime" :error="errors.datetime" cls="diesel" format="YYYY-MM-DD HH:mm"></formfield-input>

            <!--
            <formfield-input label="Date Time: " name="datetime" v-model="form.datetime" :error="errors.datetime" class="diesel" data-format="YYYY-MM-DD HH:mm" format="YYYY-MM-DD HH:mm"></formfield-input>
            -->

            <formfield-select label="Movie: " name="movie_id" v-model="form.movie_id" :error="errors.movie_id" :options="options.movie_options"></formfield-select>

            <formfield-select label="Theatre: " name="theatre_id" v-model="form.theatre_id" :error="errors.theatre_id" :options="options.theatre_options"></formfield-select>


            <formfield-submit :type="type" cancelHref="/admin/screenings"></formfield-submit>

        </form>

    </div>
</template>

<script>
import itemForm from "@packagesBase/mixins/itemForm";

export default {
    name: "ScreeningForm",
    mixins: [itemForm],
    data() {
        return {
        }
    },
    mounted: function() {
        initDiesel();
    }
}
</script>

<style scoped>

</style>
