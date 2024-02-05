@extends('layouts.plantilla')
@section('titulo', 'Añadir nuevo libro')

@section('contenido')
<h1 class="text-2xl font-bold mb-4">{{ 'Agregar Nuevo Libro' }}</h1>

<form action="{{ route('books.update', $book) }}" method="POST" class="space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label for="idModule" class="block text-sm font-medium text-gray-700">Module:</label>
        <select id="idModule" name="idModule" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option disabled>Selecciona una opcion</option>
            @foreach ($modules as $module)
                <option value="{{ $module->code }}" {{ (isset($book) && $book->idModule == $module->code) ? 'selected' : '' }}>
                    {{ $module->cliteral }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="publisher" class="block text-sm font-medium text-gray-700">Publisher:</label>
        <input type="text" name="publisher" id="publisher" value="{{ $book->publisher ?? '' }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price:</label>
        <input type="number" name="price" id="price" value="{{ $book->price ?? '' }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label for="pages" class="block text-sm font-medium text-gray-700">Pages:</label>
        <input type="number" name="pages" id="pages" value="{{ $book->pages ?? '' }}" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Status:</label>
        <div class="mt-2">
            <label for="status1" class="inline-flex items-center"></label>
            <input type="radio" id="status1" name="status" value="good" {{ (isset($book) && $book->status == 'good') ? 'checked' : '' }} required class="form-radio h-5 w-5 text-indigo-600">
            <span class="ml-2 text-gray-700">Bueno</span>

            <label for="status2" class="inline-flex items-center ml-6"></label>
            <input type="radio" id="status2" name="status" value="bad" {{ (isset($book) && $book->status == 'bad') ? 'checked' : '' }} class="form-radio h-5 w-5 text-indigo-600">
            <span class="ml-2 text-gray-700">Malo</span>

            <label for="status3" class="inline-flex items-center ml-6"></label>
            <input type="radio" id="status3" name="status" value="new" {{ (isset($book) && $book->status == 'new') ? 'checked' : '' }} class="form-radio h-5 w-5 text-indigo-600">
            <span class="ml-2 text-gray-700">Nuevo</span>
        </div>
    </div>

    <button type="submit" class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700">Actualizar</button>
</form>

@endsection
