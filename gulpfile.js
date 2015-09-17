var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    //mettre tous nos css ensemble avec des import dans app.scss
    mix.sass('app.scss', 'resources/assets/css');

    //mixer les style externe ensemble
    mix.styles([
        'libs/normalize.css',
        'libs/bootstrap.min.css',
        'app.css',
        'libs/select2.min.css',
        'libs/jasny-bootstrap.css',
        'libs/jquery-ui.min.css',
    ]);

    //version avec elixir
    mix.version('public/css/all.css');

    mix.scripts([
        'libs/jquery-2.1.4.min.js',
        'libs/bootstrap.min.js',
        'libs/select2.min.js',
        'libs/jasny-bootstrap.min.js',
        //'libs/jquery-ui.min.js',
        'libs/jquery.autocomplete.js',
        'alert.js',
        'autocompleteInfo.js',
    ]);



    //test for php routes
    //mix.phpUnit();
    
});
