<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ofertas;
use App\Models\Ciclos;
use App\Models\User;
use App\Notifications\CambiarContrasenyaNotification;

class OfertasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ciclosId = auth()->user()->ciclosComoResponsable->pluck('id');
        $ofertas = Ofertas::whereHas('ciclos', function ($query) use ($ciclosId) {
            $query->whereIn('id', $ciclosId);
        })->paginate(10);

        return view('ofertas.index', compact('ofertas'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $oferta = Ofertas::findOrFail($id);
        return view('ofertas.show', compact('oferta'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $oferta = Ofertas::findOrFail($id);
        $oferta->estado = 'caducada';
        $oferta->update();
        $oferta->delete();
    }


    public function estadisticas()
    {
        $totalOfertas = Ofertas::withTrashed()->count(); // Obtener el total de ofertas, incluyendo las eliminadas

        $stats = Ciclos::withCount(['ofertas' => function ($query) {
            $query->withTrashed(); // Incluye ofertas eliminadas
        }])
            ->with(['ofertas' => function ($query) {
                $query->withCount('alumnos')->withTrashed(); // Incluye ofertas eliminadas y cuenta los alumnos
            }])
            ->paginate(10);

        return view('ofertas.stats', compact('stats', 'totalOfertas'));
    }


}
