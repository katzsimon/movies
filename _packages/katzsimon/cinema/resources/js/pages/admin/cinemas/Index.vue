<template>
    <admin-layout :title="ui.names" :breadcrumbs="breadcrumbs">

        <admin-item-filter @update-filter="update"></admin-item-filter>

        <div class="box">
            <table class="table table-bordered table-hover table-middle table-items">
            <thead>
            <tr>
                <th class="center uppercase">ID</th>
                <th class="uppercase">Location</th>
                <th class="uppercase">Name</th>
                <th class="">
                    <layout-item-create :item="ui.items" :name="ui.name"></layout-item-create>
                </th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="item in items">
                    <td class="center">{{ item.id }}</td>
                    <td>{{ item.location }}</td>
                    <td>{{ item.name }}</td>
                    <td class="">
                        <inertia-link :href="`/admin/cinemas/${item.id}/theatres`" class="inline-flex relative justify-center rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-xs font-medium text-gray-700 hover:bg-gray-50" style="top:-3px;">Theatres ({{ item.theatres_count }})</inertia-link>

                        <layout-item-menu :edit="true" :delete="true" :item="ui.items" :id="item.id" :title="item.title"></layout-item-menu>
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
        }
    },

}
</script>

<style scoped>

</style>
