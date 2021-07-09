const mix = require("laravel-mix");
const path = require("path");

mix.setPublicPath("public/vendor/vague")
    .js("resources/js/app.js", "js")
    .vue()
    .postCss("resources/css/app.css", "css", [
        require("tailwindcss"),
    ])
    .webpackConfig({
        output: {
            publicPath: '/vendor/vague/',
            chunkFilename: 'js/[name].js?id=[chunkhash]'
        },
        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
            },
        },
    })
    .sourceMaps()
    .version();