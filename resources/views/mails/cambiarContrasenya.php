@extends('layouts.plantilla')
@section('titulo', 'Listado de libros')
@section('contenido')
<div class="container mx-auto mt-4">
    <a href="{{ route('users.edit', id) }}" class="text-blue-500 hover:text-blue-800"><h1 class="text-2xl font-bold mb-4">Haz clic en este texto para cambiar la contraseña</h1></a>

    
</div>

@endsection


