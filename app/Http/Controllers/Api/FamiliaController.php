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
     */
    /**
     * @OA\Get(
     *      path="/api/familias",
     *      operationId="getFamiliasList",
     *      tags={"Familias"},
     *      summary="Get list of Familias",
     *      description="Returns list of Familias",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/FamiliaResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
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
    public function show(Familias $familias)
    {
        //
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
