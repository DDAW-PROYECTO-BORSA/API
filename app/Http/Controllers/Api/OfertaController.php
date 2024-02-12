<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EmpresaResource;
use App\Http\Resources\OfertaCollection;
use App\Http\Resources\OfertaResource;
use App\Models\Empresas;
use App\Models\Ofertas;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ValidarOfertaNotification;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ofertas = Ofertas::with('ciclos')->get();
        return new OfertaCollection($ofertas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $admin = User::where('rol', 'administrador')->first();

            // Crear oferta
            $oferta = new Ofertas();
            $oferta->idEmpresa = $request->idEmpresa;
            $oferta->descripcion = $request->descripcion;
            $oferta->duracion = $request->duracion;
            $oferta->contacto = $request->contacto == null ? $oferta->empresa->contacto : $request->contacto;
            $oferta->metodoInscripcion = $request->metodoInscripcion;
            $oferta->email = $request->metodoInscripcion == 'email' ? $request->email : null;
            $oferta->estado = $request->estado;
            $oferta->validado = 0;

            $ciclos = $request->ciclos;
            $oferta->save();
            $oferta->ciclos()->attach($ciclos);

            $admin->notify(new ValidarCiclosNotification($alumno, $ciclo));
            foreach ($oferta->ciclos as $ciclo) {
                $ciclo->usuarioResponsable->notify(new ValidarOfertaNotification($oferta->empresas->user, $oferta));
            }


            return response()->json(new OfertaResource($oferta),201);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $oferta = Ofertas::findOrFail($id);
        return response()->json(new OfertaResource($oferta), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        try {
            // Crear oferta
            $oferta = Ofertas::findOrFail($id);
            $oferta->idEmpresa = $request->idEmpresa;
            $oferta->descripcion = $request->descripcion;
            $oferta->duracion = $request->duracion;
            $oferta->contacto = $request->contacto == null ? $oferta->empresa->contacto : $request->contacto;
            $oferta->metodoInscripcion = $request->metodoInscripcion;
            $oferta->email = $request->metodoInscripcion == 'email' ? $request->email : null;
            $oferta->estado = $request->estado;
            $oferta->validado = 0;

            $ciclos = $request->ciclos;
            $oferta->update();
            $oferta->ciclos()->sync($ciclos);

            return response()->json(new OfertaResource($oferta),200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $oferta = Ofertas::findOrFail($id);
            $oferta->estado = 'caducada';
            $oferta->update();
            $oferta->delete();
            return response()->json('Su oferta con id ' . $id . ' ha sido eliminada',200);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }

    }
}
