<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        <meta name="csrf_token" content="{{ csrf_token() }}"  >
        <title>Image Uploader</title>
    </head>
    <body>
        <div class="max-w-lg mx-auto mt-24">
             <h1 class="font-bold text-4xl text-center">Image Uploader</h1>
             <div id="app">
                
             </div>
        </div>
        <script src="{{ mix('js/app.js') }}" ></script>
    </body>
</html>