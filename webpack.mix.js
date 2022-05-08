const mix = require('laravel-mix');

const paths = {
    'SOURCE': './resources/',
    'DESTINATION': './public/'
}

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

mix.setPublicPath(paths.DESTINATION)

mix.js(paths.SOURCE + 'js/site.js', paths.DESTINATION + 'js/site.js')

mix.postCss(paths.SOURCE + 'css/tailwind.css', paths.DESTINATION + 'css/site.css', [
    require('postcss-import'),
    require('tailwindcss/nesting'),
    require('tailwindcss'),
])

mix.browserSync({
    files: [
        'app/**/*',
        'public/**/*',
        'resources/views/**/*',
        'resources/lang/**/*',
        'routes/**/*'
    ],
    proxy: 'statamic-starterkit-dummy.local'
})

if (mix.inProduction()) {
    mix.version()
}

mix.disableNotifications()

/*
 |--------------------------------------------------------------------------
 | Statamic Control Panel
 |--------------------------------------------------------------------------
 |
 | Feel free to add your own JS or CSS to the Statamic Control Panel.
 | https://statamic.dev/extending/control-panel#adding-css-and-js-assets
 |
 */

// mix.js(paths.SOURCE + 'js/cp.js', paths.DESTINATION + 'vendor/app/js')
//    .postCss(paths.SOURCE + 'css/cp.css', paths.DESTINATION + 'vendor/app/css', [
//     require('postcss-import'),
//     require('tailwindcss/nesting'),
//     require('tailwindcss'),
// ])
