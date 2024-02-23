<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BorsaBatoi - gestió</title>

    <!-- Fonts -->

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
        <div class="max-w-4xl px-8 py-12 bg-white shadow-lg rounded-lg animate__animated animate__fadeIn">
            <h1 class="text-3xl font-semibold text-gray-600 mb-4">Bienvenido a BorsaBatoi</h1>
            <p class="text-gray-600 mb-6">Una plataforma de gestión de prácticas para estudiantes.</p>
            <p class="text-red-600 mb-6">Ha ocurrido un error de autenticación: {{ $missatge }}</p>
            <a href="/login" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded inline-flex items-center transition duration-300 ease-in-out">
                <span>Vuelve al inicio</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="w-4 h-4 ml-2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>
    </div>
</body>
</html>
