const mix = require("laravel-mix");

mix.setPublicPath("public")
    .js("resources/js/app.js", "js")
    .vue()
    .postCss("resources/css/app.css", "css", [
        require("tailwindcss"),
    ])
    .sourceMaps()
    .version();