<template>

    <div>
        <inertia-link :href="href" class="text-white bg-blue-600 py-2 px-3 inline-block rounded hover:no-underline hover:bg-blue-700">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="inline">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add <span class="hidden sm:inline">{{ name }}</span>
        </inertia-link>
    </div>

</template>

<script>
export default {
    name: "LayoutItemCreate",
    data() {
        return {
        }
    },
    props: {
        name: String,
        item: String,
        parent: {type:Object|null, default:null}
    },
    computed: {
        href: function(){
            if (this.parent!==null) {
                return `/admin/${this.parent.item}/${this.parent.id}/${this.item}/create`;
            } else {
                return `/admin/${this.item}/create`;
            }
        }
    }
}
</script>

<style scoped>

</style>
