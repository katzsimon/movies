/*
Common functionality for the Admin Edit Form
 */
import AdminLayout from '@packagesBase/templates/AdminLayout'
export default {
    components: {
        AdminLayout,
    },
    data() {
        return {
            form: this.$props.item,
        }
    },
    props: {
        errors: Object,
        item: Object,
        ui: Object,
        breadcrumbs: Array,
    },
    remember: ['item', 'form'],
    created: function () {
    },
}
