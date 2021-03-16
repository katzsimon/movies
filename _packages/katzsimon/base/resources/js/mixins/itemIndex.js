/*
Common functionality for the Admin Index pages
 */
import AdminLayout from "@packagesBase/templates/AdminLayout";
import LayoutItemCreate from "@packagesBase/templates/AdminItemCreate";
import LayoutItemMenu from "@packagesBase/templates/AdminItemMenu";
import AdminItemFilter from "@packagesBase/templates/AdminItemFilter";

export default {
    components: {
        AdminLayout,
        LayoutItemCreate,
        LayoutItemMenu,
        AdminItemFilter
    },
    data() {
        return {
            filterText: ''
        }
    },
    props: {
        data: [Object, Array],
        ui: [Object, Array],
        breadcrumbs: [Object, Array],
    },
    computed: {
        items: function(){

            let preFilter = this.data;
            let filterText = this.filterText.toLowerCase();

            return preFilter.filter(
                function(item) {
                    let merged = Object.keys(item).map(function (key, index) {
                        return item[key];
                    }).join(' ').toLowerCase();
                    return merged.includes(filterText);
                }
            );
        }
    },
    mounted: function () {
    },
    methods: {
        update(filter) {
            this.filterText = filter;
        }
    }
}
