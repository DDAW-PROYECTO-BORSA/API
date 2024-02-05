@extends('layouts.plantilla')
@section('titulo', 'Listado de libros')

@section('contenido')
    <x-fitxa-libro-component book='{{ $book->id }}'></x-fitxa-libro>
@endsection
