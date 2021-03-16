<!--
Form Select Component

Wraps the common functionality to make working with Form Elements easier
-->
<template>
    <div>

        <div class="frm-group mb-4">
            <label :for="name" class="control-label">{{ label }}</label>
            <div class="flex w-full flex-column">
                <div class="flex w-full">

                <select
                    :name="name"
                    :id="name"
                    class="form-control"
                    :type="type"
                    :readonly="readonly"
                    :placeholder="placeholder"

                    :value="value"
                    @input="updateInput($event.target.value)"

                >
                    <option v-for="(option, index) in options" :key="index" :value="index">{{ option }}</option>
                </select>


                </div>
                <div class="text-danger" v-if="error">{{ error }}</div>

            </div>
        </div>



    </div>
</template>

<script>
export default {
    name: "FormfieldSelect",
    inheritAttrs: false,
    data() {
        return {
        }
    },
    props: {
        label: String,
        name: String,
        field: String,
        type: {type:String, default:'text'},
        readonly: {type:Boolean, default:false},
        error: String,
        rows: {type:Number, default:3},
        placeholder: String,
        options: Object|Array,

        value: {type:[String,Number], default:''},
    },
    methods: {
        updateInput(newValue){
            this.$emit('input', newValue);
        }
    }
}
</script>

<style scoped>

</style>
