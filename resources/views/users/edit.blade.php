@extends('layouts.plantillaNoNav')
@section('titulo', 'Cambiar contraseña')

@section('contenido')
<div class="max-w-md mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">{{ $user->name }}, cambia tu contraseña.</h1>

    <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6 mt-4 mb-4 bg-white rounded-lg shadow-md">
        @csrf
        @method('PUT')
        <div class="space-y-6">
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Contraseña:</label>
                <input id="password" name="password" type="password" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>

            <div>
                <label for="password2" class="block mb-2 text-sm font-medium text-gray-700">Confirma la contraseña:</label>
                <input id="password2" name="password2" type="password" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>
        </div>

        

        <button type="submit" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md w-full hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition ease-in-out duration-150">
            Aplicar
        </button>
    </form>
</div>
@endsection
