import Dashboard from './components/DashboardComponent.vue';
import Inicio from './components/InicioComponent.vue';
import contrasena from './components/CreateContrasenaComponent.vue';
import recuperar from './components/RecuperarContrasenaComponent.vue';

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
    },
    {
        path: '/cambiar-contrasena',
        component: contrasena,
        beforeEnter: (to, from, next) => {
          next();
        }
    },
    {
        path: '/recuperar-contrasena',
        component: recuperar,
        beforeEnter: (to, from, next) => {
          next();
        }
    },
]