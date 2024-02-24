<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Loopple/loopple-public-assets@main/motion-tailwind/motion-tailwind.css">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="text-center min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <h1 class="text-5xl dark:text-white font-semibold text-gray-800 mb-4">Bienvenido a BorsaBatoi</h1>
            <h2 class="text-2xl dark:text-white text-gray-600 mb-6">La plataforma de gestión de la bolsa de trabajo del CIPFP Batoi.</h2>
            <h2 class="text-xl dark:text-white text-gray-600 mb-6">Si eres alumno o empresa, inicia sesión <a class="font-semibold hover:text-blue-600" href="https://app2.projecteg4.ddaw.es/">AQUÍ</a></h2>
            <h2 class="text-xl dark:text-white text-gray-600 mb-6">Por favor, inicia sesión para continuar</h2>
            <div class="w-full sm:max-w-md mt-1 px-6 py-4 bg-white shadow-2xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
