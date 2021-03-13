<template>
    <div>
        <ol class="w-full flex flex-row justify-end">
            <li v-for="(breadcrumb, index) in breadcrumbs" class="inline">
                <inertia-link v-if="breadcrumb.href" :href="breadcrumb.href" :class="breadcrumb.active">
                {{ breadcrumb.text }}
                </inertia-link>
                <span v-else class="text-blue-500">
                    {{ breadcrumb.text }}
                </span>

                <span v-if="index != breadcrumbs.length - 1" class="mx-2"> / </span>

            </li>
        </ol>

    </div>
</template>

<script>
export default {
    name: "Breadcrumbs",
    props : {
        breadcrumbs: {type:Array, default:[]}
    }
}
</script>

<style scoped>

</style>
