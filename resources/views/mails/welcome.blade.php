@extends('layouts.plantilla')
@section('titulo', 'Felicitaciones')

@section('contenido')
    <p>Bienvenido {{ $user->name }}, te has registrado correctamente</p>
@endsection
