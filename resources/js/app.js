/**
 * Load all JavaScript dependencies
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Automatically register Vue components recursively 
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Create a fresh Vue application instance and attach it to the page. 
 */

const app = new Vue({
    el: '#app',
});
