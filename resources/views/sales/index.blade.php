@extends('layouts.plantilla')
@section('titulo', 'Ventas de usuario')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Ventas de {{ Auth::user()->name }}</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Book ID</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Autor Libro</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Comprador</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Fecha Compra</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    @php
                        $book = $sale->books;
                        $user = $sale->user;

                    @endphp
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->id }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $book->user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $user->name }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $sale->created_at }}</td>

                        <td class="px-5 py-5 border-b border-gray-200 text-sm"><a href="{{ route('books.show', $book->id) }}" class="underline text-blue-500 hover:text-blue-800">Ver Libro</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $sales->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>

@endsection
