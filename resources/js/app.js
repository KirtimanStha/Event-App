require('./bootstrap');

import { createApp } from 'vue';

import router from './router';
import App from './components/App.vue';
// import "bootstrap/dist/css/bootstrap.min.css";
// import "bootstrap";

const app = createApp(App);
app.use(router).mount("#app");

// createApp(App).use(router).mount('#app')
// createApp({
//     components: {
//         App,
//         Welcome,
//         EventList
//     }
// }).use(router).mount('#app')
