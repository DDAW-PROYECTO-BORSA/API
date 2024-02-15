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
     *      summary="Get list of Ciclos",
     *      description="Returns list of ciclos",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/CicloResource")
     *       ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
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
    public function show(Ciclos $ciclos)
    {
        //
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
