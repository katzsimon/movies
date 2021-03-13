require('./bootstrap');

window.axios.defaults.headers.common['Request-Source'] = 'vue';

import Vue from 'vue';
window.Vue = Vue;

import store from '@packagesBase/plugins/_store.js';
import router from '@packagesBase/plugins/_router.js';
import vuetify from '@packagesBase/plugins/_vuetify.js';
import meta from '@packagesBase/plugins/_meta';
import App from '@packagesBase/App.vue';

Vue.prototype.$eventHub = new Vue();

var app = new Vue({
    el: '#app',
    vuetify,
    router,
    store,
    render: h=>h(App),
    beforeCreate() {
        this.$store.commit('initialiseStore');
    },
    created: function(){
        axios.interceptors.request.use(
            request => {
                var token = this.$store.state.token;
                if (token!=='') {
                    request.headers['Authorization'] = 'Bearer ' + token;
                }
                return request;
            },
            error => {
                return Promise.reject(error)
            }
        )
    },
});
