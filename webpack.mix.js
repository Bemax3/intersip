const mix = require("laravel-mix");
const path = require("path");

mix.alias({ ziggy: path.resolve("vendor/tightenco/ziggy/dist/vue") });

mix.js("resources/js/app.js", "public/js")
    .js("resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js", "public/js")
    .js("resources/libs/countup.js/dist/countUp.js", "public/js")
    .js("resources/libs/apexcharts/dist/apexcharts.min.js", "public/js")
    .js("resources/libs/litepicker/dist/litepicker.js", "public/js")
    .js("resources/libs/nouislider/dist/nouislider.min.js", "public/js")
    .js("resources/libs/tom-select/dist/js/tom-select.base.min.js", "public/js")
    .vue({ version: 3 })
    .webpackConfig({
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "resources/js"),
            },
        },
        output: {
            chunkFilename: "js/[name].js?id=[chunkhash]",
        },
    })
    .extract()
    .postCss("resources/css/app.css", "public/css", [
        //
    ])
    .version();
