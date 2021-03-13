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
                    <th class="center w-24">ID</th>
                    <th class="">User</th>
                    <th class="">Screening</th>
                    <th class="">Seats</th>
                    <th class="">Reference</th>
                    <th class="">
                        <layout-item-create :item="ui.items" :name="ui.name"></layout-item-create>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in items">
                    <td class="center">{{ item['id'] }}</td>
                    <td v-html="item['user_details']">

                    </td>
                    <td>
                        {{ item['screening_theatre'] }}<br>
                        <strong>{{ item['screening_movie'] }}</strong><br>
                        {{ item['screening_when'] }}
                    </td>
                    <td>{{ item['seats'] }}</td>
                    <td>{{ item['reference'] }}</td>
                    <td class="">
                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.title" :extras="extras"></layout-item-menu>
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
        genres:[Object, Array]
    },
    data() {
        return {
            genreList: this.$props.genres,
            "extras":[{text:"Cancel Booking", href:"/admin/booking/{id}/cancel", method:"post"}],
        }
    },

}
</script>

<style scoped>

</style>
