<!--
Admin Submit Button(s) Component
-->
<template>
    <div>
        <div class="">
            <button type="submit" class="btn btn-primary">{{ buttonText }}</button>
            <inertia-link :href="cancelHref" class="btn btn-light">Cancel</inertia-link>
        </div>
    </div>
</template>

<script>
export default {
    name: "FormfieldSubmit",
    inheritAttrs: false,
    data() {
        return {
        }
    },
    props: {
        type: {type:String, default:'create'},
        cancelHref: {type:String, default:'#'}
    },
    computed: {
        buttonText: function(){

            if (this.$props.type==='create') {
                return 'Create';
            } else {
                return 'Update'
            }

        },
    },
}
</script>

<style scoped>

</style>
