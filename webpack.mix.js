const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

mix.disableNotifications();

// <!-- Font Awesome -->
// <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
//     <!-- Ionicons -->
//     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
//     <!-- overlayScrollbars -->
//     <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
//     <!-- DataTables -->
//     <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.css">
//     <!-- Google Font: Source Sans Pro -->
// <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
