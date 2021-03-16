/*
Common functionality for working with an Admin Form
 */
import FormfieldInput from "@packagesBase/components/FormfieldInput";
import FormfieldSubmit from "@packagesBase/components/FormfieldSubmit";
import FormfieldSelect from "@packagesBase/components/FormfieldSelect";

export default {
    props: {
        errors: Object,
        ui: [Object, Boolean],
        form: Object,
        type: {type:String, default:'create'},
        options: Object,
        parent: Object
    },
    components: {
        FormfieldInput,
        FormfieldSelect,
        FormfieldSubmit
    },
    computed: {
        buttontext: function(){
            if (this.$props.type==='create') {
                return 'Create';
            } else {
                return 'Update'
            }
        },
    },
    mounted: function () {
    },
    methods: {
        onSubmit(event) {


            if (this.type==='create') {

                if (this.parent) {
                    this.$inertia.post(this.$route(`admin.${this.ui['parent-items']}.${this.ui['items']}.store`, [this.parent.id]), this.form, {
                        onSuccess: page => {
                            this.$eventHub.$emit('toast', `The ${this.ui.name} has been created`, 'Success', 'success');
                        },
                        onError: errors => {
                            this.$eventHub.$emit('toast', 'Please fix the errors before you can continue', 'Error!', 'danger');
                        }
                    });
                } else {
                    this.$inertia.post(this.$route(`admin.${this.ui.items}.store`), this.form, {
                        onSuccess: page => {
                            this.$eventHub.$emit('toast', `The ${this.ui.name} has been created`, 'Success', 'success');
                        },
                        onError: errors => {
                            this.$eventHub.$emit('toast', 'Please fix the errors before you can continue', 'Error!', 'danger');
                        }
                    });
                }



            } else if (this.type==='edit') {

                if (this.parent) {
                    this.$inertia.patch(this.$route(`admin.${this.ui['parent-items']}.${this.ui.items}.update`, [this.parent.id, this.form.id]), this.form, {
                        onSuccess: page => {
                            this.$eventHub.$emit('toast', `The ${this.ui.name} has been updated`, 'Success', 'success');
                        },
                        onError: errors => {
                            this.$eventHub.$emit('toast', 'Please fix the errors before you can continue', 'Error!', 'danger');
                        }
                    });
                } else {
                    this.$inertia.patch(this.$route(`admin.${this.ui.items}.update`, [this.form.id]), this.form, {
                        onSuccess: page => {
                            this.$eventHub.$emit('toast', `The ${this.ui.name} has been updated`, 'Success', 'success');
                        },
                        onError: errors => {
                            this.$eventHub.$emit('toast', 'Please fix the errors before you can continue', 'Error!', 'danger');
                        }
                    });
                }

            }
        },
    }
}
