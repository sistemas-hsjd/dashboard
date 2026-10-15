import './bootstrap';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import { createRouter, createWebHistory } from 'vue-router';
import Routes from './routes.js';
import ModalEstadosEnlacesComponent from './components/modals/ModalEstadosEnlacesComponent.vue';

const app = createApp({});
app.component('modal-estados-enlaces-component', ModalEstadosEnlacesComponent);
const router = createRouter({
    routes:Routes,
    history: createWebHistory(),
});
app.use(router);
app.mount('#app');
