/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import PokemonsComponent from "./components/PokemonsComponent";

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import axios from 'axios'

Vue.use(Vuetify, axios)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/InitComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('init-component', require('./components/InitComponent.vue').default);
Vue.component('default-component', require('./components/DefaultComponent.vue').default);
Vue.component('pokemons-component', require('./components/PokemonsComponent.vue').default);
Vue.component('types-component', require('./components/TypesComponent.vue').default);
Vue.component('regions-component', require('./components/RegionsComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify(),
});
