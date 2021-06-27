<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LaravelBnb</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Importar stylesheet de bootstrap -->
        <link rel="stylesheet" href="{{asset('css/app.css')}}">



    <!-- Se usa 'asset()', para buscar recursos dentro de la carpeta "public", en este caso, se está importando un script de javascript
        "defer" se usa para indicar que el script se debe ejecutar una vez que la página ha sido completamente cargada-->
    <script src="{{asset('js/app.js')}}" defer></script>
    </head>

    <body>
        <!-- Se usa el id "app", para indicar que se debe usar la consola de desarrollo de Vue -->
        <div id="app">
            <index> </index>
        </div>
    </body>
</html>
