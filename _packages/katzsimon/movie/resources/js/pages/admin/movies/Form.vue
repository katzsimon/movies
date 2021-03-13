<template>
    <div>

        <form @submit.prevent="onSubmit">

            <formfield-input label="ID: " name="id" v-model="form.id" readonly></formfield-input>

            <formfield-input label="Name: " name="name" v-model="form.name" :error="errors.name"></formfield-input>

            <formfield-input label="Starring: " name="starring" v-model="form.starring" :error="errors.starring"></formfield-input>

            <formfield-input label="Genre: " name="genre" v-model="form.genre" :error="errors.genre"></formfield-input>

            <formfield-input label="Runtime (minutes): " name="runtime" v-model="form.runtime" :error="errors.runtime"></formfield-input>

            <formfield-input label="Description: " type="textarea" name="description" v-model="form.description" :error="errors.description"></formfield-input>


            <formfield-submit :type="type" cancelHref="/admin/movies"></formfield-submit>

        </form>

    </div>
</template>

<script>
import itemForm from "@packagesBase/mixins/itemForm";

export default {
    name: "Form",
    mixins: [itemForm],
    data() {
        return {
        }
    },
}
</script>

<style scoped>

</style>
