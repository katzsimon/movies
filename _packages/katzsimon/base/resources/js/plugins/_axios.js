import Vue from "vue";

import VueAxios from "vue-axios";
import axios from "axios";
Vue.use(VueAxios, axios);

function axiosSetup(axios) {
    console.log('hmmm');
}

export default axiosSetup;
