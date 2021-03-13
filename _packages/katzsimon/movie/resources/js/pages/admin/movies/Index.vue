<template>
    <admin-layout :title="ui.names" :breadcrumbs="breadcrumbs">

        <admin-item-filter @update-filter="update"></admin-item-filter>

        <div class="box">
            <div class="mb-2">
                <inertia-link v-for="(genre, index) in genres" v-bind:key="index" :href="$route('admin.movies.index.genre', [genre.title])" class="text-blue-400 hover:text-blue-700 hover:no-underline mr-3 inline-block">{{ genre.title }} ({{ genre.count }})</inertia-link>
            </div>
            <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center">ID</th>
                <th>NAME</th>
                <th>GENRE</th>
                <th class="text-center">RATING</th>
                <th class="">
                    <layout-item-create :item="ui.items" :name="ui.name"></layout-item-create>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td class="center">{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.genre }}</td>
                    <td class="text-center">{{ item.rating }}</td>
                    <td class="">
                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.name" :extras="extras"></layout-item-menu>
                    </td>
                </tr>
            </tbody>
        </table>
        </div>

    </admin-layout>
</template>

<script>
import itemIndex from "@packagesBase/mixins/itemIndex";

export default {
    "name": "Index",
    "mixins": [itemIndex],
    "props": {
        "genres":[Object, Array]
    },
    "data"() {
        return {
            "genreList": this.$props.genres,
            "extras":[{text:"Delete Movie with Screenings", href:"/admin/movies/{id}/screenings", method:"delete"}],
        }
    },
    "mounted": function() {
    },
    "methods": {
    }
}
</script>

<style scoped>

</style>
