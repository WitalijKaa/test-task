<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <link type="text/css" href="/css/materialize.css" rel="stylesheet" media="screen,projection">
        <link href="/css/app.css" rel="stylesheet">

        <script src="/js/admin.js"></script>
        <script src="/js/materialize.js"></script>
    </head>
    <body>
        <div class="row">
            <div class="col s12 m8 offset-m2">

                <table>
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>ID</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </body>
</html>
