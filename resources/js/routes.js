import Dashboard from './components/DashboardComponent.vue';

export default [

    {
        path: '/inicio',
        component: Dashboard,
        beforeEnter: (to, from, next) => {
            next(); 
        }
    }
]