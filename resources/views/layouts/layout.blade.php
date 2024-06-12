<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href={{ Vite::asset('resources/images/logoforestfy.png') }}/>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Icons-->
    @vite(['resources/fonts/materialdesignicons.css'])
    <!-- Styles -->
    @yield('styles')
    
    <!-- Scripts -->
    @vite(['resources/js/app.js'])

</head>
<body>
    @yield('content')   
    @yield('scripts') 
</body>