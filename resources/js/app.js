import './bootstrap';
import { createApp, h } from 'vue';
import { createRouter, createWebHistory, RouterView } from 'vue-router';
import Routes from './routes.js';
import ModalEstadosEnlacesComponent from './components/modals/ModalEstadosEnlacesComponent.vue';

const app = createApp({render: () => h(RouterView)});
const router = createRouter({
    routes:Routes,
    history: createWebHistory(),
});
app.use(router);
app.mount('#app');

if (document.getElementById('portal-admin-modals')) {
    createApp(ModalEstadosEnlacesComponent).mount('#portal-admin-modals');
}
