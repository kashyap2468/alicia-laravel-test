/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import  Form from 'vform'
import  HasError from 'vform'
import  AlertError from 'vform'
import Toasted from 'vue-toasted';

Vue.use(Toasted, {
    duration: 1500,
    position: 'top-center'
});

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

export const axios = require('axios').create({ baseURL: 'https://jsonplaceholder.typicode.com/photos', responseType: 'json' })
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/HomePage.vue').default);
Vue.component('login-component', require('./components/login.vue').default);
Vue.component('register-component', require('./components/Register.vue').default);
Vue.component('ToastNotification', require('./components/ToastNotification.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
