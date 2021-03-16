<!--
Display an animated circular loader while the page is loading

Hidden with the $eventHub method:
this.$eventHub.$emit('setPageLoaded', true);
-->
<template>
    <div class="d-flex justify-center">
        <v-progress-circular v-if="!pageLoaded"
                             indeterminate
                             color="blue"
        ></v-progress-circular>
    </div>
</template>

<script>
export default {
    name: "Loading",
    data() {
        return {
            pageLoaded:false
        }
    },
    mounted: function(){
        this.$eventHub.$on('setPageLoaded', this.updatePageLoadingStatus);
    },
    beforeDestroy() {
        this.$eventHub.$off('setPageLoaded');
    },
    methods: {
        updatePageLoadingStatus(loadingStatus) {
            this.pageLoaded = loadingStatus;
        }
    }
}
</script>

<style scoped>
</style>
