<template>
    <div>

        <form @submit.prevent="onSubmit">

            <formfield-input label="ID: " name="id" v-model="form.id" readonly></formfield-input>

            <formfield-input label="Location: " name="location" v-model="form.location" :error="errors.location"></formfield-input>

            <formfield-input label="Name: " name="name" v-model="form.name" :error="errors.name"></formfield-input>


            <formfield-submit :type="type" cancelHref="/admin/cinemas"></formfield-submit>

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
