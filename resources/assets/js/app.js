
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.axios 		= require('axios');
window.VueAxios 	= require('vue-axios');
window.VeeValidate = require('vee-validate');

window.swal = require('sweetalert2');

const VueValidationEs = require('vee-validate/dist/locale/es');

Vue.use(VueAxios, axios);
Vue.use(VeeValidate, {
    locale: 'es',
    dictionary: {
      es: VueValidationEs
    }
});

window.moment = require('moment');
moment().format();

window.utm = require('utm');

// import 'jquery-ui/ui/widgets/datepicker';
// import 'jquery-ui/themes/base/core.css';
// import 'jquery-ui/themes/base/theme.css';
// import 'jquery-ui/themes/base/datepicker.css';


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

 // Vue.component('example-component', require('./components/ExampleComponent.vue'));
 Vue.component('select2', require('./components/select.vue'));


//Vue.component('v-select', require('./components/select.vue'));

// const app = new Vue({
//     el: '#app'
// });

