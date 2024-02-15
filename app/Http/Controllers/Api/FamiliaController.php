<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FamiliaResource;
use App\Models\Familias;
use Illuminate\Http\Request;

class FamiliaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *      path="/api/familias",
     *      operationId="getFamiliasList",
     *      tags={"Familias"},
     *      summary="Pedir la lista de familias",
     *      description="Devuelve la lista de todas las familias registradas",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/FamiliaResource")
     *       )
     *     )
     */
    public function index()
    {
        return FamiliaResource::collection(Familias::all());
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
     *      path="/api/familias/{id}",
     *      operationId="getFamiliaById",
     *      tags={"Familias"},
     *      summary="Pedir la información de una familia",
     *      description="Devuelve la información de la familia requerida a partir de su id",
     *      @OA\Parameter(
     *           name="id",
     *           description="Familia id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Operación realizada con éxito",
     *          @OA\JsonContent(ref="#/components/schemas/FamiliaResource")
     *       ),
     *     @OA\Response(
     *           response=400,
     *           description="Bad Request"
     *       )
     *     )
     */
    public function show(int $id)
    {
        $familia = Familias::findOrFail($id);
        return response()->json(new FamiliaResource($familia), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Familias $familias)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Familias $familias)
    {
        //
    }
}
