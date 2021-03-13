export default {
    props: {
        flash:Object,
    },
    mounted: function () {
        this.$eventHub.$on('toast', this.toast);
        //console.log('Flash Message: ', this.$page.props.flash.message);
        if (this.$page.props.flash && this.$page.props.flash.message) {
            let message = this.$page.props.flash.message.message || this.$page.props.flash.message || '';
            let title = this.$page.props.flash.message.title || '';
            let variant = this.$page.props.flash.message.type || this.$page.props.flash.message.variant || this.$page.props.flash.message.context || '';
            if (message!=='' || typeof message!=='undefined') this.toast(message, title, variant);
        }
    },
    beforeDestroy() {
        this.$eventHub.$off('toast');
    },
    methods: {
        toast: function(message, title, variant) {

            this.$bvToast.toast(message, {
                title: title,
                variant: variant,
                solid: true
            })

        }
    }
}
