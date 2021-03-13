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
const mode = process.env.MIX_MODE;
const packages = process.env.MIX_PACKAGES_PATH

// Admin Assets
if (mode==='inertia' || mode==='admin' || mode==='') {
    console.log('Mix Compiling Inertia');

    mix
        .webpackConfig(require('./webpack.config'))
        .setPublicPath('public_html/')
        .js(`${packages}/base/resources/js/admin.js`, 'js').vue({ version: 2 })
        .sass(`${packages}/base/resources/css/admin.scss`, 'css', [])
            .options({
                processCssUrls: false,
                postCss: [tailwindcss('./tailwind.config.js')],
            })
        ;
}

// App Assets
if (mode==='vue' || mode==='app' || mode==='') {
    console.log('Mix Compiling Vue');

    mix
        .webpackConfig(require('./webpack.config'))
        .setPublicPath('public_html/')
        .js(`${packages}/base/resources/js/app.js`, 'js').vue({ version: 2 })
        .sass(`${packages}/base/resources/css/app.scss`, 'css', [])
        .options({
            processCssUrls: false,
            postCss: [tailwindcss('./tailwind.config.js')],
        })
    ;
}

mix.browserSync({proxy:'movies.test',notify:false});
