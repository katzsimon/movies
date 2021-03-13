import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex);

// Encode the store so it is not stored as plain text
const encode = false;

const store = new Vuex.Store({
    state: {
        auth: false,
        user: {},
        token: ''
    },
    mutations: {
        initialiseStore(state) {
            // Check if the ID exists

            if(localStorage.getItem('store')) {
                try {
                    let stored = localStorage.getItem('store');
                    if (encode===true) stored = atob(stored);
                    stored = JSON.parse(stored);
                    //let stored = JSON.parse(atob((localStorage.getItem('store'))));
                    //if (stored.token) stored.token = stored.token;
                    this.replaceState(
                        Object.assign(state, stored)
                    );
                } catch(e) {

                }

            }
        },
        setUser (state, user) {
            state.user = user;
            state.auth = true;
        },
        setToken(state, token) {
            state.token = token;
            state.auth = true;
        },
        login (state, token, user) {
            state.user = user;
            state.token = token;
            state.auth = true;
        },
        logout (state) {
            state.user = {};
            state.token = '';
            state.auth = false;
            localStorage.removeItem('store');
        }
    },
    getters: {
        auth: (state, getters) => {
            return state.auth;
        },
        noauthed: (state, getters) => {
            return !state.auth;
        },
        isLoggedIn: (state, getters) => {
            return state.auth;
        },
        notLoggedIn: (state, getters) => {
            return !state.auth;
        },
    },

})
window.Vuex = store;
store.subscribe((mutation, state) => {
    // Store the state object as a JSON string
    let store = {
        auth: state.auth,
        user: state.user,
        token: state.token,
    };

    if (encode===true) {
        localStorage.setItem('store', btoa(JSON.stringify(store)));
    } else {
        localStorage.setItem('store', JSON.stringify(store));
    }

    //localStorage.setItem('store', JSON.stringify(store));

});
export default store;
