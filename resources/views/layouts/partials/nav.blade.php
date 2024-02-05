<nav class="bg-gray-800 p-2 mt-0 w-full">
    <div class="container mx-auto flex justify-between">
        <a class="text-white text-3xl font-bold" href="#">BatoiBooks</a>
        <div class="flex items-center space-x-1">
            <a class="py-2 px-2 text-white" href="{{ route('inici') }}">Inicio</a>
            @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="py-2 px-2 text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="py-2 px-2 text-white">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 py-2 px-2 text-white">Register</a>
                        @endif
                    @endauth
            @endif
        </div>
    </div>
</nav>
