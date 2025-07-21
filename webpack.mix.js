const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
     require('tailwindcss'),
     require('autoprefixer'),
   ])
   .webpackConfig({
     output: { chunkFilename: 'js/[name].js?id=[chunkhash]' }
   })
   .version();
