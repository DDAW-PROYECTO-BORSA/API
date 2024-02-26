@extends('layouts.plantilla')
@section('titulo', 'Estadísticas de ofertas')
@section('contenido')
    <div class="container mx-auto mt-4">
        <h1 class="text-2xl font-bold mb-4">Estadísticas de Ofertas</h1>
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Ciclo</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Número de ofertas</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Número de ofertas activas</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Porcentaje de ofertas</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Número total de inscripciones</th>
                    <th class="px-5 py-3 border-b-2 border-gray-200 text-center text-sm uppercase font-semibold">Media de inscripciones por oferta</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($stats as $stat)
                    @php
                        $totalInscripciones = 0;
                        $totalActivas = 0;
                    @endphp
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $stat->ciclo }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $stat->ofertas_count }}</td>
                        @foreach ($stat->ofertas as $oferta)
                            @php
                                $totalInscripciones += $oferta->alumnos_count;
                                $totalActivas = $oferta->estado == 'activa' ? $totalActivas + 1 : $totalActivas + 0;
                            @endphp
                        @endforeach
                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $totalActivas }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $stat->ofertas_count > 0 ? round(($stat->ofertas_count / $totalOfertas) * 100, 2) : 0 }}%</td>

                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $totalInscripciones }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 text-center text-sm">{{ $totalInscripciones > 0 ? round($totalInscripciones / $stat->ofertas_count, 2) : 0 }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $stats->links() }}
        </div>
    </div>
@endsection
