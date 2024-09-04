const mix = require('laravel-mix');

mix.setPublicPath('public');
mix.version();

mix.postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
]);