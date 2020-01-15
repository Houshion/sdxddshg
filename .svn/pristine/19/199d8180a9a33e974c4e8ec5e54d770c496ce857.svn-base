// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from "vue";
import App from "./App";
import router from "./router";
import VueProgressBar from "vue-progressbar";
import VueLocalStorage from 'vue-localstorage';
import VueBus from 'vue-bus';
import Mint from 'mint-ui';
import "mint-ui/lib/style.css";

Vue.use(VueBus);
Vue.use(Mint);
Vue.use(VueLocalStorage);
Vue.use(VueProgressBar, {
    color: '#18ac16',
    failedColor: 'red',
    thickness: '3px',
});

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    template: '<App/>',
    components: {App}
});
