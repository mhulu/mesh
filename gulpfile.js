var elixir = require('laravel-elixir');
require ('laravel-elixir-vueify');
require('laravel-elixir-imagemin');
var gulp = require('gulp');
/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

if(elixir.config.production == true){
    process.env.NODE_ENV = 'production';
}

elixir.config.images = {
    folder: 'img',
    outputFolder: 'img'
};

elixir(function(mix) {
    mix.sass('app.scss');
    mix.imagemin();
    mix.browserify('main.js');
    mix.browserify('init.js', './public/js/init.js');
});
