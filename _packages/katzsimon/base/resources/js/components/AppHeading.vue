<template>
    <h1 class="page-title">
        <slot />
    </h1>
</template>

<script>
export default {
    name: "AppHeading",
    props: {
    }
}
</script>

<style scoped>
h1.page-title {
    margin-bottom:2rem;
    margin-top:1rem;
    font-size:3rem;
    font-weight: 400;
    font-family: Roboto,sans-serif!important;
}
</style>
