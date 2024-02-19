@extends('layouts.plantilla')
@section('titulo', 'Ficha empresa')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">empresa</h1>
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
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $empresa->user->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $empresa->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $empresa->user->direccion }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $empresa->user->email }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('users.edit', $empresa->user->id) }}" class="text-yellow-500 hover:text-yellow-800 ml-2">Editar</a>

                           {{--  @auth
                                @if (Auth::empresa()->id == $empresa->idempresa)
                                    <form action="{{ route('empresas.destroy', $empresa->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-800 ml-2">Eliminar</button>
                                    </form>
                                @endif
                            @endauth --}}
                        </td>
                    </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
