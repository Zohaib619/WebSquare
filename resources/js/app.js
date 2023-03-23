import './bootstrap';
import { createApp } from 'vue';
import App from './Layouts/App.vue';
import router from './route';

createApp(App).use(router).mount("#app")