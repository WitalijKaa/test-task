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

    <h6 class="center">{{ $header }}</h6>

    {{ $slot }}

</div>
@livewireScripts
</body>
</html>
