<template>
    <admin-layout title="Dashboard">

        <div class="box">

        </div>

    </admin-layout>
</template>

<script>
import AdminLayout from '@packagesBase/templates/AdminLayout'
export default {
    name: "AdminDashboard",
    props: {
        bookings: Array,
    },
    data() {
        return {
        }
    },
    components: {
        AdminLayout,
    },
    mounted: function() {
    },
    methods: {
    }
}
</script>

<style scoped>

</style>
