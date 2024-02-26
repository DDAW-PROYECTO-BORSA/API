<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresas;
use App\Models\Ofertas;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ActivarCuentaNotification;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/api/empresas",
     *      operationId="getEmpresasList",
     *      tags={"Empresas"},
     *      summary="Pedir la lista de empresas",
     *      description="Devuelve la lista de todas las empresas registradas",
     *      security={ {"apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/EmpresaResource")
     *       ),
     *     @OA\Response(
     *           response=401,
     *           description="Unauthenticated",
     *       ),
     *       @OA\Response(
     *           response=403,
     *           description="Forbidden"
     *       )
     *     )
     */

    public function index()
    {
        $empresas = Empresas::all();
        return new EmpresaCollection($empresas);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *      path="/api/empresas",
     *      operationId="storeEmpresa",
     *      tags={"Empresas"},
     *      summary="Guarda un nuevo usuario con el rol de empresa y crea un registro de empresa",
     *      description="Devuelve los datos de la empresa guardada",
     *      security={ {"apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","direccion","email","password","CIF","contacto"},
     *              @OA\Property(property="name", type="string", example="CIPFP Batoi S.A."),
     *              @OA\Property(property="CIF", type="string", example="B59015379"),
     *              @OA\Property(property="direccion", type="string", example="C/Sant Nicolau, 36, 03802 Alcoi, Alacant"),
     *              @OA\Property(property="contacto", type="string", example="Caroline Welch"),
     *              @OA\Property(property="web", type="string", example="www.myweb.com"),
     *              @OA\Property(property="password", type="string", example="PassWord12345")
     *          )
     *      ),
     *      @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/EmpresaResource")
     *        ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Internal server error"
     *       )
     * )
     */

    public function store(EmpresaRequest $request)
    {
        try {
            $existeEmpresa = Empresas::where('CIF', $request->CIF)->first();

            if($existeEmpresa){
                return response()->json("Esta empresa ya existe", 500);

            }else{
                 // Crear usuario
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->direccion = $request->direccion;
            $user->rol = 'empresa';

            $user->save();
            // Crear la empresa asociada al usuario
            $empresa = new Empresas();
            $empresa->CIF = $request->CIF;
            $empresa->contacto = $request->contacto;
            $empresa->web = $request->web;

            // Guardar la empresa asociada al usuario
            $user->empresa()->save($empresa);
            $user->notify(new ActivarCuentaNotification($user));


            return response()->json(new EmpresaResource($empresa),201);
            }

        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *      path="/api/empresas/{id}",
     *      operationId="getEmpresaById",
     *      tags={"Empresas"},
     *      summary="Pedir la información de una empresa",
     *      description="Devuelve la información de la empresa requerida a partir de su id de usuario",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *           name="id",
     *           description="Usuario id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AlumnoResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function show(int $id)
    {

        $user = Auth::user();
        $empresa = Empresas::findOrFail($id);

        if($user->rol == 'empresa' && $user->id == $id){
            return response()->json(new EmpresaResource($empresa), 200);
        } elseif($user->rol == 'alumno'){
            $ciclosAlumno = $user->alumno->ciclos->pluck('id');
            $ofertas = Ofertas::whereHas('ciclos',function ($query) use ($ciclosAlumno) {
                $query->whereIn('idCiclo', $ciclosAlumno->toArray())->where('estado','activa')->where('validado',true);
            })->get();
            if(!$ofertas->isEmpty()){
                return response()->json(new EmpresaResource($empresa), 200);
            } else {
                return response()->json(['error' => 'La empresa no tiene ofertas activas para los ciclos cursados por el alumno'], 404);
            }
        } else {
            return response()->json(['error' => 'No tienes permitido ver la empresa'], 403);
        }

    }


    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *      path="/api/empresas/{id}",
     *      operationId="updateEmpresa",
     *      tags={"Empresas"},
     *      summary="Actualizar datos de la empresa",
     *      description="Devuelve los datos actualizados de la empresa",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de usuario",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EmpresaRequest")
     *      ),
     *     @OA\Response(
     *           response=202,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/EmpresaResource")
     *        ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */

    public function update(EmpresaRequest $request, int $id)
    {
        $empresa = Empresas::findOrFail($id);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->direccion = $request->direccion;
        $user->update();

        $empresa->contacto = $request->contacto;
        $empresa->web = $request->web;
        $empresa->update();

        return response()->json(new EmpresaResource($empresa),200);
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/empresas/{id}",
     *      operationId="deleteEmpresa",
     *      tags={"Empresas"},
     *      summary="Eliminar una empresa registrada",
     *      description="Elimina el registro de la empresa y no devuelve nada",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="ID usuario",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $empresa = Empresas::find($id);
            $empresa->delete();

            $user = User::find($id);
            $user->delete();

            return response()->json('La empresa con id ' . $id . ' ha sido eliminada.', 204);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
