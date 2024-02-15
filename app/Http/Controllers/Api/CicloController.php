<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CicloCollection;
use App\Http\Resources\CicloResource;
use App\Models\Ciclos;
use Illuminate\Http\Request;

class CicloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/api/ciclos",
     *      operationId="getCiclosList",
     *      tags={"Ciclos"},
     *      summary="Pedir la lista de ciclos",
     *      description="Devuelve la lista de todos los ciclos registrados",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CicloResource")
     *       )
     *     )
     */
    public function index()
    {
        $ciclos = Ciclos::all();
        return new CicloCollection($ciclos);
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

    /**
     * @OA\Get(
     *      path="/api/ciclos/{id}",
     *      operationId="getCicloById",
     *      tags={"Ciclos"},
     *      summary="Pedir la información de un ciclo",
     *      description="Devuelve la información del ciclo requerido a partir de su id",
     *      @OA\Parameter(
     *           name="id",
     *           description="Ciclo id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CicloResource")
     *       ),
     *     @OA\Response(
     *           response=400,
     *           description="Bad Request"
     *       )
     *     )
     */

    public function show(int $id)
    {
        $ciclo = Ciclos::findOrFail($id);
        return response()->json(new CicloResource($ciclo), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ciclos $ciclos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ciclos $ciclos)
    {
        //
    }
}
