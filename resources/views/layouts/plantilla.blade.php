<html>
<head>
    <title>
        @yield('titulo')
    </title>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto px-4">
        @yield('contenido')
    </div>
</body>
</html>
