<template>
    <admin-layout :title="ui.names" :breadcrumbs="breadcrumbs">

        <div class="box">
            <table class="table table-bordered table-hover table-middle table-items">
                <thead>
                <tr>
                    <th class="center w-24">ID</th>
                    <th class="">Movie</th>
                    <th class="">Cinema</th>
                    <th class="">Theatre</th>
                    <th class="center">When</th>
                    <th class="center">Seats Available</th>
                    <th class="">
                        <layout-item-create :item="ui.items" :name="ui.name"></layout-item-create>
                    </th>
                </tr>
                </thead>

            <tbody>
                <tr v-for="item in upcomingScreenings">
                    <td class="center">{{ item.id }}</td>
                    <td>{{ item.movie_name }}</td>
                    <td>{{ item.cinema_name }}</td>
                    <td>{{ item.theatre_name }}</td>
                    <td class="center">{{ item.datetime }}</td>
                    <td class="center">{{ item.seats_available }}</td>
                    <td class="">
                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.title"></layout-item-menu>
                    </td>
                </tr>
            </tbody>
        </table>


            <div v-if="pastScreenings" class="mt-8">
            <h3 class="text-2xl mb-2">Past Screenings</h3>
            <table class="table table-bordered table-hover table-middle table-items">
                <thead>
                <tr>
                    <th class="center w-24">ID</th>
                    <th class="">Movie</th>
                    <th class="">Cinema</th>
                    <th class="">Theatre</th>
                    <th class="center">When</th>
                    <th class="center">Seats Available</th>
                    <th class="">

                    </th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="item in pastScreenings">
                    <td class="center">{{ item.id }}</td>
                    <td>{{ item.movie_name }}</td>
                    <td>{{ item.cinema_name }}</td>
                    <td>{{ item.theatre_name }}</td>
                    <td class="center">{{ item.datetime }}</td>
                    <td class="center">{{ item.seats_available }}</td>
                    <td class="">
                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.title"></layout-item-menu>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>

        </div>

    </admin-layout>
</template>

<script>
import itemIndex from "@packagesBase/mixins/itemIndex";

export default {
    name: "Index",
    mixins: [itemIndex],
    props: {
        upcomingScreenings:[Object, Array],
        pastScreenings:[Object, Array],
    },
    data() {
        return {
        }
    },

}
</script>

<style scoped>

</style>
