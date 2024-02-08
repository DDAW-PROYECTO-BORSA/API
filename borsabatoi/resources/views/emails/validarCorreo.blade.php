@extends('layouts.plantilla')
@section('titulo', 'Listado de libros')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Confirma tu email</h1>
    @if ($user->rol == 'alumno')
        <form action="{{ route('alumno.activarCuenta', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">Activar cuenta</button>
        </form>
    @else
            {{-- <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">Activar cuenta</button> --}}
    @endif
</div>

@endsection


