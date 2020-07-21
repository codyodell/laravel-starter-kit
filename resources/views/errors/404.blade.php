<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Resource Not Found | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <link href="//fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
</head>

<body>
    <div id="app">
        <v-app>
            <v-container>
                <v-sheet>
                    <h1>{{ page_name }}</h1>
                    <p>{{ page_description }}</p>
                </v-sheet>
            </v-container>
        </v-app>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script>
        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            page_name: '404',
            page_description: 'Page not found.',
        });
    </script>
</body>

</html>
