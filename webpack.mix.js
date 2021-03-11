const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

const packages = process.env.MIX_PACKAGES_PATH

// Admin Assets
mix
    .setPublicPath('public_html/')
    .js(`${packages}/base/resources/js/admin.js`, 'js')
    .sass(`${packages}/base/resources/css/admin.scss`, 'css', [])
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
    ;


// App Assets
mix
    .setPublicPath('public_html/')
    .js(`${packages}/base/resources/js/app.js`, 'js')
    .sass(`${packages}/base/resources/css/app.scss`, 'css', [])
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.config.js') ],
    })
;

mix.browserSync({proxy:'movies.test',notify:false});
