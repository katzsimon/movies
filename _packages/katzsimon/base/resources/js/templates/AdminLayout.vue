<template>
    <div class="flex flex-col h-100">

        <admin-nav></admin-nav>

        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-6">
                <h1 v-if="title" class="text-3xl font-bold">{{ title }}</h1>
                <breadcrumbs v-if="breadcrumbs" :breadcrumbs="breadcrumbs" class="breadcrumb "></breadcrumbs>
            </div>
        </header>
        <main class=" bg-gray-200 flex-grow">
            <div class="max-w-7xl mx-auto px-6">
                <slot />
            </div>
        </main>
    </div>
</template>

<script>
import toast from "@packagesBase/mixins/toast";
import Breadcrumbs from "@packagesBase/components/AdminBreadcrumbs";
import AdminNav from "@/templates/AdminNav";
export default {
    name: "AdminLayout",
    mixins: [toast],
    data() {
        return {
        }
    },
    props: {
        authed: Boolean,
        guest: Boolean,
        title: String,
        breadcrumbs: Array,
    },
    components: {
        Breadcrumbs,
        AdminNav
    },

    mounted: function() {
    },
    created: function(){
    }
}
</script>

<style scoped>

</style>
