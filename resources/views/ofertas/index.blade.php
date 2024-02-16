@extends('layouts.plantilla')
@section('titulo', 'Listado de ofertas')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Listado de Ofertas</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Id</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Nombre</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Direccion</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Email</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ofertas as $oferta)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $oferta->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $oferta->empresas->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $oferta->duracion }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $oferta->contacto }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('ofertas.show', $oferta->id) }}" class="text-blue-500 hover:text-blue-800">Ver</a>

                            <form action="{{ route('ofertas.destroy', $oferta->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-800 ml-2">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $ofertas->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>

@endsection
