import Vue from 'vue';
import Router from 'vue-router';
import primaryPage from './components/pages/firstview';

Vue.use(Router);

const routes = [
    {
        path:'my-new-vueroute',
        component:primaryPage
    }
];

export default new Router({
    mode:'history',
    routes
})
