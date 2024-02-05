@extends('layouts.plantilla')
@section('titulo', 'Mis libros')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Mis Libros</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Id</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Id Module</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Autor</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Publisher</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Price</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Pages</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($books as $book)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->idModule }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->publisher }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->price }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->pages }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">
                            <a href="{{ route('books.show', $book->id) }}" class="text-blue-500 hover:text-blue-800">Ver</a>
                            @auth
                                @if (Auth::user()->id == $book->idUser)
                                    <a href="{{ route('books.edit', $book->id) }}" class="text-yellow-500 hover:text-yellow-800 ml-2">Editar</a>
                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-800 ml-2">Eliminar</button>
                                    </form>
                                @endif
                            @endauth
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $books->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>

@endsection
