<template>

    <div class="relative inline-block text-left">
        <div>
            <button @click="open=!open" type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-2 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50" id="options-menu" aria-haspopup="true" aria-expanded="true">

                <!-- Heroicon name: solid/chevron-down -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                </svg>
            </button>
        </div>


        <div class="origin-top-right absolute right-0 mt-2 rounded-md shadow bg-white ring-1 ring-black ring-opacity-5 z-10" v-show="open" >
            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">

                <inertia-link v-if="edit && !parent" :href="`/admin/${item}/${id}/edit`" class="whitespace-nowrap block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline">Edit</inertia-link>
                <inertia-link v-if="edit && parent" :href="`/admin/${parent.item}/${parent.id}/${item}/${id}/edit`" class="whitespace-nowrap block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline">Edit</inertia-link>

                <inertia-link v-if="this.delete" href="#" @click.prevent="confirmDelete" class="whitespace-nowrap block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline">Delete</inertia-link>

                <inertia-link v-for="(extra, index) in extras" :key="index" :href="extra.href" @click.prevent="handleExtra(extra.href, extra.method)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 hover:no-underline whitespace-nowrap">{{ extra.text }}</inertia-link>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    name: "LayoutItemMenu",
    data() {
        return {
            open: false
        }
    },
    props: {
        name: String,
        item: String,
        id: Number,
        title: String,
        edit: Boolean,
        delete: Boolean,
        extras: Array,
        parent: Object
    },
    computed: {
        href: function(){
            return `/admin/${this.item}/create`;
        }
    },
    methods: {
        closeMenu() {
            this.open = false;
        },
        confirmDelete() {

            this.$bvModal.msgBoxConfirm(`Do you want to delete "${this.title}"?`, {
                title: 'Please Confirm',
                centered: true,
                okTitle: 'YES',
                cancelTitle: 'NO',
                okVariant: 'danger',
                cancelVariant: 'secondary',
            })
                .then(value => {

                    if (value===true) {
                        this.$inertia.delete(`/admin/${this.item}/${this.id}`, {
                            preserveScroll: true,
                            onSuccess: page => {
                                this.$bvToast.toast(`"${this.title}" has been deleted`, {
                                    title: `Deleted`,
                                    variant: 'success',
                                    solid: true
                                })
                            },
                            onError: errors => {
                                console.log('Delete Error: ', errors);
                            }
                        });
                    }
                });
        },
        close (e) {
            if (!this.$el.contains(e.target)) {
                this.open = false;
            }
        },
        handleExtra(href, method) {
            href = href.replace('{id}', this.id);

            if (method==='get') {
                this.$inertia.get(href, {
                    preserveScroll: true,
                    onSuccess: page => {
                    },
                    onError: errors => {
                    }
                });
            } else if (method==='post') {
                this.$inertia.post(href, {
                    preserveScroll: true,
                    onSuccess: page => {
                    },
                    onError: errors => {
                    }
                });
            } else if (method==='delete') {
                this.$inertia.delete(href, {
                    preserveScroll: true,
                    onSuccess: page => {
                    },
                    onError: errors => {
                    }
                });
            } else if (method==='patch') {
                this.$inertia.patch(href, {
                    preserveScroll: true,
                    onSuccess: page => {
                    },
                    onError: errors => {
                    }
                });
            }


            this.closeMenu();


        }
    },
    mounted () {
        document.addEventListener('click', this.close)
    },
    beforeDestroy () {
        document.removeEventListener('click',this.close)
    }

}
</script>

<style scoped>

</style>
