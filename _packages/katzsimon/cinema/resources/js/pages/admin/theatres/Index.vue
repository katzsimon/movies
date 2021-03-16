<template>
    <admin-layout :title="ui.names" :breadcrumbs="breadcrumbs">

        <admin-item-filter @update-filter="update"></admin-item-filter>

        <div class="box">
            <div style="margin-bottom:10px;">
                <inertia-link v-for="(genre, index) in genres" v-bind:key="index" :href="$route('admin.movies.index.genre', [genre.title])" class="text-blue-400 hover:text-blue-700 hover:no-underline mr-3 inline-block">{{ genre.title }} ({{ genre.count }})</inertia-link>
            </div>
            <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center">ID</th>
                <th>NAME</th>
                <th>MAX SEATS</th>
                <th>CINEMA</th>
                <th class="">
                    <layout-item-create :item="ui.items" :name="ui.name" :parent="parentData"></layout-item-create>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td class="center">{{ item.id }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.max_seats }}</td>
                    <td>{{ item.cinema_name }}</td>
                    <td class="">
                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.name" :parent="parentData"></layout-item-menu>
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
    name: "Index",
    mixins: [itemIndex],
    props: {
        genres:[Object, Array],
        parent:Object,
        ui: Object
    },
    data() {
        return {
            genreList: this.$props.genres
        }
    },
    computed: {
        parentData: function() {
            return {id: this.parent.id, item:this.ui['parent-items']};
        }
    }
}
</script>

<style scoped>

</style>
