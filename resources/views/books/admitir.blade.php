@extends('layouts.plantilla')
@section('titulo', 'Admitir Libro')

@section('contenido')
<h1 class="text-2xl font-bold mb-4">Libros a admitir</h1>

<form action="{{ route('books.store') }}" method="POST" class="space-y-4">
    @csrf
    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">Admitir Libro</button>
</form>

@endsection
