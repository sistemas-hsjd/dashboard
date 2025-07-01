import Dashboard from './components/DashboardComponent.vue';
import Inicio from './components/InicioComponent.vue';

export default [
    {
        path: '/',
        component: Dashboard,
        beforeEnter: (to, from, next) => {
            next(); 
        }
    },
    {
        path: '/inicio',
        component: Inicio,
        beforeEnter: (to, from, next) => {
            next(); 
        }
    }
]