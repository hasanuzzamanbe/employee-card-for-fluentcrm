let mix = require('laravel-mix');
const AutoImport = require("unplugin-auto-import/webpack");
const {ElementPlusResolver} = require("unplugin-vue-components/resolvers");
const Components = require("unplugin-vue-components/webpack");
var path = require('path');

mix.webpackConfig({
    module: {
        rules: [{
            test: /\.mjs$/,
            resolve: {fullySpecified: false},
            include: /node_modules/,
            type: "javascript/auto"
        }]

    },
    plugins: [
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
            directives: false
        }),
    ],
    resolve: {
        extensions: ['.js', '.vue', '.json'],
        alias: {
            '@': path.resolve(__dirname, 'resources/admin')
        }
    }
});

// mix.setResourceRoot('../');
mix
    .sass('src/scss/admin/app.scss', 'assets/css/element.css')
    .js('src/admin/front-end.js', 'assets/admin/js/front-end.js')
    .css('src/tailwind-assets/front-end.css', 'assets/css/front-end.css')
    .copy('src/images','assets/images');

