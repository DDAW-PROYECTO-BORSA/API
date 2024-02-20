@extends('layouts.plantilla')
@section('titulo', 'Estadísticas de ofertas')
@section('contenido')
<div class="container mx-auto mt-4">
    <h1 class="text-2xl font-bold mb-4">Estadísticas de Ofertas</h1>
    <div class="overflow-x-auto">
        <table class="min-w-full leading-normal">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Ciclo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Número de ofertas</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-left text-sm uppercase font-semibold">Número de inscripciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stats as $stat)
                @php $inscripciones = 0; @endphp
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $stat->ciclo }}</td>
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $stat->ofertas_count }}</td>
                    @foreach ($stat->ofertas as $oferta)
                        @php $inscripciones += count($oferta->alumnos); @endphp
                    @endforeach
                    <td class="px-5 py-5 border-b border-gray-200 text-sm">{{ $inscripciones }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $stats->links() }} <!-- Asegúrate de tener un componente de paginación personalizado para Tailwind CSS -->
    </div>
</div>
@endsection
