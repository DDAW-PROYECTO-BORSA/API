@extends('layouts.plantilla')
@section('titulo', 'Felicitaciones')

@section('contenido')
    <p>Felicitaciones {{ $user->name }} este año has conseguido vender libros</p>
@endsection
