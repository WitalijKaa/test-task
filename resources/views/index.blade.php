<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>Witalij Kaa</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/materialize.css', 'resources/js/materialize.js'])
        @livewireStyles
    </head>
    <body>
        <div class="row">
            <div class="col s12 m6 offset-m3">

                <h1>{{ $project }}</h1>
                <h2>{{ $qwer }}</h2>
                <h2>{{ $qwerComposer }}</h2>

                <livewire:not-vue />

            </div>
        </div>

        @livewireScripts
    </body>
</html>
