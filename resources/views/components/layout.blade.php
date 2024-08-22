<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>YESS Support</title>

    <!-- Styles -->
    @vite('resources/css/app.css')
</head>
<body class="flex flex-col h-[100vh] w-full justify-center items-center">
    {{$slot}}
</body>
</html>
