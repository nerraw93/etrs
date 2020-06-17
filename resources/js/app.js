import Vue from 'vue';
import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import VueCookies from 'vue-cookies';
import Buefy from 'buefy';
import vSelect from 'vue-select';
import axios from 'axios';
import Http from './modules/Http';
import AppMixin from './mixins/AppMixin';
import ErrorBagMixin from './mixins/ErrorBagMixin';
import Spy from './modules/Spy';
import Broadcaster from './modules/Broadcaster';
import router from './router';
import store from './store';
import Loader from '@components/global/Loader';
import 'buefy/dist/buefy.css';
import 'vue-select/dist/vue-select.css';

window.broadcaster = new Broadcaster({
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER
});

window.http = new Http();
window.AppEvent = new Spy();

Vue.use(Buefy);
Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(VueCookies);
Vue.use(VeeValidate, { events: '' });
Vue.use(Loader);
Vue.component('v-select', vSelect);
VueCookies.config('1d');

const app = new Vue({
    mixins: [
        AppMixin,
        ErrorBagMixin
    ],
    components: {
        Loader,
    },
    router,
    store,

}).$mount('#app')
