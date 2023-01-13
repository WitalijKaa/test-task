<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Witalij Kaa task_12</title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link type="text/css" href="/css/materialize.css" rel="stylesheet" media="screen,projection">
    <link href="/css/app.css" rel="stylesheet">

    <script src="/js/app.js"></script>
    <script src="/js/materialize.js"></script>
</head>
<body>
<div class="row">
    <div class="col s12 m6 offset-m3">

        <div class="card">
            <div class="card-image">
                <img id="photo" src="" alt="wait">
                <span class="card-title">Approve or decline</span>
            </div>
            <div class="card-action">
                <a id="approve" href="#">Approve</a>
                <a id="decline" href="#">Decline</a>
            </div>
        </div>

    </div>
</div>
</body>
</html>
