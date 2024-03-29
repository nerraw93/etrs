const mix = require('laravel-mix')

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
// mix.webpackConfig({
//   module: {
//     rules: [
//       {
//         enforce: 'pre',
//         test: /\.(js|vue)$/,
//         loader: 'eslint-loader',
//         exclude: /node_modules/
//       }
//     ]
//   }
// })

mix.extend('alias', new class {
    webpackConfig(webpackConfig) {
        webpackConfig.resolve.alias = {
            'vue$': 'vue/dist/vue.esm.js',
            '@': __dirname + '/resources/js',
            '@store': __dirname + '/resources/js/store',
            '@components': __dirname + '/resources/js/components',
            '@sass': __dirname + '/resources/sass',

        }
    }
})

mix.alias()

mix.js('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/pdf.scss', 'public/css')
.sass('resources/sass/api_documentation.scss', 'public/css')
.js('resources/js/api_doc.js', 'public/js')
.version();
