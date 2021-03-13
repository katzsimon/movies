require('./bootstrap');

import { App, plugin } from '@inertiajs/inertia-vue'
import Vue from 'vue'
Vue.use(plugin)

Vue.prototype.$route = route

import { InertiaProgress } from '@inertiajs/progress'
InertiaProgress.init()


import bs from '@packagesBase/plugins/_bootstrap_admin.js';

Vue.prototype.$eventHub = new Vue();


Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        this.event = function (event) {
            if (!(el === event.target || el.contains(event.target))) {
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', this.event)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', this.event)
    },
});


const el = document.getElementById('app')

new Vue({
    render: h => h(App, {
        props: {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => {

                let parts = name.split('::');

                if (parts.length===3) {
                    let author = parts[0];
                    let pack = parts[1];
                    let paths = parts[2];
                    let pathParts = paths.split('/');
                    let root = pathParts[0];
                    let path = pathParts[1];
                    let component = pathParts[2];

                    // Unfortunately have to hard code the paths for webpack
                    if (author==='katzsimon' && (component==='Dashboard')) {
                        return require(`@/${paths}`).default;
                    } else if (author==='katzsimon' && (path==='Login' || path==='Register')) {
                        return require(`@@/katzsimon/auth/resources/js/pages/${paths}`).default;
                    } else if (author==='katzsimon' && (pack==='base')) {
                        return require(`@@/katzsimon/base/resources/js/pages/${component}`).default;
                    } else if (author==='katzsimon' && pack==='movies') {
                        return require(`@@/katzsimon/movie/resources/js/pages/${paths}`).default;
                    } else if (author==='katzsimon' && (pack==='cinemas' || pack==='theatres' || pack==='screenings' || pack==='bookings')) {
                        return require(`@@/katzsimon/cinema/resources/js/pages/${paths}`).default;
                    }

                }

                return require(`@packages/base/resources/js/pages/admin/${name}`).default;

            }
        },
    }),
}).$mount(el)
