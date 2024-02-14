@extends('layouts.plantilla')
@section('titulo', 'Asignar responsable')

@section('contenido')
<h1 class="text-2xl font-bold mb-4">{{ 'Asignar responsable al ciclo: '. $ciclo->cliteral }}</h1>

<form action="{{ route('ciclos.update', $ciclo) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="responsable" class="block text-sm font-medium text-gray-700">Responsable:</label>
        
        <select id="responsable" name="responsable" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            @foreach ($responsables as $responsable)
                <option value="{{ $responsable->id }}" {{ (isset($ciclo) && $ciclo->responsable == $responsable->id) ? 'selected' : '' }}>
                    {{ $responsable->name }}
                </option>
            @endforeach
        </select>

    </div>
    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">Actualizar</button>
</form>

@endsection
