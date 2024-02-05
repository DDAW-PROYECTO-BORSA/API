<div class="container mx-auto mt-20">
    <div class="bg-white shadow-lg rounded-lg">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-center text-3xl font-bold">Ficha Libro</h1>
        </div>
        <div class="p-6">
            <h3 class="text-center text-xl mb-2">ID del Módulo: <span class="text-gray-600">{{ $book->idModule }}</span></h3>
            <h3 class="text-center text-xl mb-2">Autor: <span class="text-gray-600">{{ $book->user->name }}</span></h3>
            <h3 class="text-center text-xl mb-2">Editorial: <span class="text-gray-600">{{ $book->publisher }}</span></h3>
            <h3 class="text-center text-xl mb-2">Precio: <span class="text-gray-600">{{ $book->price }}</span></h3>
            <h3 class="text-center text-xl mb-2">Páginas: <span class="text-gray-600">{{ $book->pages }}</span></h3>
        </div>
        <div class="text-center">
            <button class="px-4 py-2 bg-indigo-500 text-white rounded-md hover:bg-indigo-700"><a href="{{ route('books.comprar', ['id' => $book->id]) }}">Comprar</a></button>
        </div>
        
    </div>
</div>
