<template>
    <div>

        <div class="frm-group mb-4">
            <label :for="name" class="control-label">{{ label }}</label>
            <div class="flex w-full flex-col">
                <div class="flex w-full">
                <input  v-if="type==='text' || type==='password' || type==='number'"
                    :name="name"
                    :id="name"
                    class="form-control"
                    :class="cls"
                    :type="type"
                    :readonly="readonly"
                    :placeholder="placeholder"
                    :data-format="format"
                    :value="value"
                    @input="updateInput($event.target.value)"
                    v-bind="inputAttrs"

                />



                    <textarea  v-if="type==='textarea'"
                            :name="name"
                            :id="name"
                            class="form-control"
                            :type="type"
                            :readonly="readonly"
                            :placeholder="placeholder"
                            :rows="rows"
                            @input="updateInput($event.target.value)"

                    >{{ value }}</textarea>
                </div>

                <div class="text-red-400" v-if="error">{{ error }}</div>
                <div class="text-gray-600" v-if="info">{{ info }}</div>


            </div>
        </div>



    </div>
</template>

<script>
export default {
    name: "FormfieldInput",
    inheritAttrs: false,
    data() {
        return {
            rootClass:''
        }
    },
    props: {
        label: String,
        name: String,
        field: String,
        cls: String,
        type: {type:String, default:'text'},
        readonly: {type:Boolean, default:false},
        error: String,
        info: String,
        rows: {type:Number, default:3},
        placeholder: String,
        format:String,
        value: {type:[String,Number], default:''},
    },
    computed:{
        inputAttrs(){

            return this.$attrs;
            return '';
        }
    },
    methods: {
        updateInput(newValue){
            this.$emit('input', newValue);
        }
    },
    mounted: function(){
        // Move class from root element to input field
        this.rootClass = this.$el.className;
        this.$el.className = '';

        // Move data attributes from root element to input field
        let input = this.$el.querySelector('input, textarea');
        let attrs = this.$attrs;
        for (const property in this.$attrs) {
            if (property.indexOf('data-')===0) {
                input.setAttribute(property, attrs[property] );
                this.$el.removeAttribute(property);
            }
        }

    }
}
</script>

<style scoped>

</style>
