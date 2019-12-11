let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
	.extract(['vue', 'axios', 'vue-axios', 'select2', 'vee-validate', 'sweetalert2'])
	.scripts([
		'node_modules/select2/dist/js/i18n/es.js',
		'node_modules/pc-bootstrap4-datetimepicker/build/js/bootstrap-datetimepicker.min.js'
	], 'public/js/plugins.js')
	.styles([
    	'node_modules/select2/dist/css/select2.min.css',
    	'node_modules/sweetalert2/dist/sweetalert2.min.css',
    	'node_modules/pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
    ], 'public/css/plugins.css')
	.sass('resources/assets/sass/app.scss', 'public/css')
	.copy('resources/assets/css', 'public/css')
	.copy('resources/assets/img', 'public/images');
