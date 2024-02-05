@extends('layouts.plantilla')
@section('titulo', 'Libro comprado')

@section('contenido')
    <h1>El libro de {{ $book->publisher }} ha sido comprado</h1>
@endsection
