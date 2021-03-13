<template>
    <div class="box">

            <div class="relative flex w-full border-gray-400 border2 border-solid border-2 rounded" style="border-width:1px !important">
                <div class="px-3 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="" width="24" height="24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>

                <input type="text" placeholder="Filter..." v-model="filterTextLocal" @keyup="update" @update="update" @dblclick="clear" class="flex-grow py-2.5 pl-0 pr-3 placeholder-gray-400 text-gray-700 relative bg-white bg-white rounded text-sm outline-none focus:outline-none focus:shadow-outline" />
            </div>

    </div>

</template>

<script>
export default {
    name: "AdminItemFilter",

    data() {
        return {
            filterTextLocal: ''
        }
    },

    methods: {
        update() {
            this.$emit("update-filter", this.filterTextLocal);
        },
        clear() {
            this.filterTextLocal = '';
            this.$emit("update-filter", this.filterTextLocal);
        }
    }

}
</script>

<style scoped>

</style>
