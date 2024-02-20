@extends('layouts.plantilla')
@section('titulo', 'Nuevo Responsable')

@section('contenido')
<div class="max-w-md mx-auto mt-10">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800">Nuevo Responsable</h1>

    <form action="{{ route('users.store') }}" method="POST" class="p-6 mt-4 mb-4 bg-white rounded-lg shadow-md">
        @csrf
        @method('POST')

        <div class="space-y-6">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Nombre:</label>
                <input id="name" name="name" type="text" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="direccion" class="block mb-2 text-sm font-medium text-gray-700">Direccion:</label>
                <input id="direccion" name="direccion" type="text" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email:</label>
                <input id="email" name="email" type="email" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>
            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Contraseña:</label>
                <input id="password" name="password" type="password" class="block w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
            </div>
            
        </div>

        <button type="submit" class="px-4 py-2 mt-4 text-white bg-indigo-500 rounded-md w-full hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 transition ease-in-out duration-150">
            Aplicar
        </button>
    </form>
</div>
@endsection
