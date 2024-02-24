@extends('layouts.plantilla')
@section('titulo', 'Listado de usuarios')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Listado de Usuarios</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Id</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Nombre</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Apellidos</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Direccion</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Email</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Rol</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->name }}</td>

                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            @if($user->alumno)
                                {{ $user->alumno->apellido }}
                            @endif
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->direccion }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->email }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->rol }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('users.show', $user->id) }}" class="text-blue-500 hover:text-blue-800">Ver</a>
                            <a href="{{ route('users.edit', $user->id) }}" class="text-yellow-500 hover:text-yellow-800 ml-2">Editar</a>
                            @if($user->rol == 'alumno' && auth()->user()->rol === "administrador" && !$user->activado)
                                <a href="{{ url('/alumnos/activar/' . $user->id ) }}" class="text-green-500 hover:text-green-800">Activar</a>
                            @endif
                            //activar ciclos
                           {{--  @auth
                                @if (Auth::user()->id == $user->idUser)
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline">
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
        {{ $users->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>

@endsection
