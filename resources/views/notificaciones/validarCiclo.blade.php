@extends('layouts.plantillaNoNav')
@section('titulo', 'Validado')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Se ha validado el ciclo: {{ $ciclo->cliteral }}. Para el alumno {{ $alumno->user->name }}</h1>
</div>

@endsection


