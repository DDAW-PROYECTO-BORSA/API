@extends('layouts.plantillaNoNav')
@section('titulo', 'Oferta validada')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Se ha validado la oferta de la empresa: {{ $oferta->empresas->user->name }}</h1>
</div>

@endsection


