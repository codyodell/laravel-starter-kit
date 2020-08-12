const mix = require("laravel-mix");
const VuetifyLoaderPlugin = require("vuetify-loader/lib/plugin");

mix
    .js("resources/js/admin/admin.js", "public/js")
    .js("resources/js/front/front.js", "public/js")
    .sass("resources/sass/admin.scss", "public/css")
    .sass("resources/sass/front.scss", "public/css")
    .sourceMaps()
    .extract(["vue", "vue-router", "moment", "axios", "lodash", "dropzone"]);

mix
    .copy("resources/img/*", "public/images")
    .copy("resources/manifest.json", "public");

//if (mix.inProduction()) mix.sourceMaps();

mix.browserSync(process.env.APP_URL);
