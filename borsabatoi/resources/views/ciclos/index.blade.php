@extends('layouts.plantilla')
@section('titulo', 'Listado de libros')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Listado de Ciclos</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Id</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Ciclo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">vliteral</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">clitera</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Familia</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Responsable</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ciclos as $ciclo)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->ciclo }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->vliteral }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->cliteral }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->familia->cliteral }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $ciclo->usuarioResponsable->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('ciclos.show', $ciclo->id) }}" class="text-blue-500 hover:text-blue-800">Ver</a>
                            <a href="{{ route('ciclos.edit', $ciclo->id) }}" class="text-yellow-500 hover:text-yellow-800 ml-2">Editar</a>

                           {{--  @auth
                                @if (Auth::user()->id == $ciclo->idUser)
                                    <form action="{{ route('ciclos.destroy', $ciclo->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-800 ml-2">Eliminar</button>
                                    </form>
                                @endif
                            @endauth --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $ciclos->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>

@endsection
