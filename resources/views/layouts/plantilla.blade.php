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
    @if (Auth::user() === null)
        @include('layouts.partials.nav')
    @else
        @include('layouts.navigation')
    @endif

    {{-- @include('layouts.partials.nav') --}}
    @yield('contenido')
</div>
</body>
</html>
