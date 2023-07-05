require('./bootstrap');

// Import modules...
import Vue from 'vue';
import vuetify from './Plugins/vuetify'
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import 'vuetify/dist/vuetify.min.css';
import '@mdi/font/css/materialdesignicons.css';
Vue.use(InertiaPlugin);

// Localize With Extension Day.js
import 'dayjs/locale/ja';
import dayjs from 'dayjs';
dayjs.locale('ja');

// Register Global Event
window.EventEmitter = new Vue();

// Vue Custom Filter
import * as filters from "./filter";
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

const app = document.getElementById('app');
new Vue({
  vuetify,
  render: (h) =>
    h(InertiaApp, {
      props: {
        initialPage: JSON.parse(app.dataset.page),
        resolveComponent: (name) => require(`./Pages/${name}`).default,
      },
    }),
}).$mount(app);