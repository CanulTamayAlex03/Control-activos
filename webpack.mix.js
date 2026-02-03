const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/layout.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
       require('postcss-import'),
   ])
   .postCss('resources/css/layout.css', 'public/css', [])
   .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
   .options({
       processCssUrls: false
   });
