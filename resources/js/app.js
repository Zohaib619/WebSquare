import './bootstrap';
import { createApp } from 'vue';
import App from './Layouts/App.vue';
import router from './route';
import  store  from './Store/index.js';


createApp(App)
    .use(router)
    .use(store)
    .mount("#app")