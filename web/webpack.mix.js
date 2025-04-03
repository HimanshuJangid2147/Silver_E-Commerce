const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .styles([
        'public/css/bootstrap.min.css',
        'public/css/venobox.css',
        'public/css/plugin_theme_css.css',
        'public/css/style.css',
        'public/css/responsive.css'
    ], 'public/css/all.css')
    .scripts([
        'public/js/jquery-3.5.1.min.js',
        'public/js/bootstrap.min.js',
        'public/js/isotope.pkgd.min.js',
        'public/js/owl.carousel.min.js',
        'public/js/slick.min.js',
        'public/js/imagesloaded.pkgd.min.js',
        'public/js/venobox.min.js',
        'public/js/jquery.appear.js',
        'public/js/jquery.knob.js',
        'public/js/theme-pluginjs.js',
        'public/js/jquery.meanmenu.js',
        'public/js/ajax-mail.js',
        'public/js/theme.js'
    ], 'public/js/app.js');
