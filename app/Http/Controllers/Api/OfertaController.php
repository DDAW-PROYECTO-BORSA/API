<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfertaCollection;
use App\Http\Resources\OfertaResource;
use App\Models\Ciclos;
use App\Models\Ofertas;
use App\Models\User;
use App\Models\Alumnos;
use App\Http\Resources\AlumnoCollection;

use App\Notifications\ValidarCiclosNotification;
use Exception;
use Illuminate\Http\Request;
use App\Notifications\ValidarOfertaNotification;
use Illuminate\Support\Facades\Auth;

class OfertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *      path="/api/ofertas",
     *      operationId="getOfertasList",
     *      tags={"Ofertas"},
     *      summary="Pedir la lista de ofertas",
     *      description="Devuelve la lista de todas las ofertas registradas",
     *      security={ {"apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/OfertaResource")
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
        $user = Auth::user();
        if($user->rol === 'administrador') {
            $ofertas = Ofertas::with('ciclos')->get();
        } elseif ($user->rol === 'responsable'){
            $ciclosResponsable = $user->ciclosComoResponsable->pluck('id');
            $ofertas = Ofertas::whereHas('ciclos',function ($query) use ($ciclosResponsable) {
                $query->whereIn('idCiclo', $ciclosResponsable);
            })->get();
        } elseif ($user->rol === 'empresa'){
            $ofertas = Ofertas::where('idEmpresa',$user->id)->get();
        } elseif($user->rol === 'alumno'){
            $alumno = Alumnos::findOrFail($user->id);
            $ciclosAlumno = $alumno->ciclos->pluck('id');
            $ofertas = Ofertas::whereHas('ciclos',function ($query) use ($ciclosAlumno) {
                $query->whereIn('idCiclo', $ciclosAlumno->toArray())->where('estado','activa')->where('validado',true);
            })->get();
        }

        return new OfertaCollection($ofertas);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *      path="/api/ofertas",
     *      operationId="storeOferta",
     *      tags={"Ofertas"},
     *      summary="Guarda una nueva oferta",
     *      description="Devuelve los datos de la oferta guardado",
     *      security={ {"apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"idEmpresa","apellidos","direccion","email","CV","password","ciclosA"},
     *              @OA\Property(property="descripcion", type="string", example="Se ofrece puesto de pinche de cocina en restaurante de Alcoi"),
     *              @OA\Property(property="duracion", type="integer", example="2"),
     *              @OA\Property(property="contacto", type="string", example="Joana Mira Martinez"),
     *              @OA\Property(property="metodoInscripcion", type="string", example="email"),
     *              @OA\Property(property="email", type="string", example="user1@mail.com"),
     *              @OA\Property(property="password", type="string", example="PassWord12345"),
     *              @OA\Property(property="ciclos", type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="idCiclo", type="integer", example=1)
     *              )
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/OfertaResource")
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
     *      )
     * )
     */

    public function store(Request $request)
    {
        try {
            $admin = User::where('rol', 'administrador')->first();
            $user = Auth::user();

            // Crear oferta
            $oferta = new Ofertas();
            $oferta->idEmpresa = $user->id;
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

            foreach ($oferta->ciclos as $ciclo) {
                $ciclo->usuarioResponsable->notify(new ValidarOfertaNotification($user, $oferta));
            }

            return response()->json(new OfertaResource($oferta),201);
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *      path="/api/ofertas/{id}",
     *      operationId="getOfertaById",
     *      tags={"Ofertas"},
     *      summary="Pedir la información de una oferta",
     *      description="Devuelve la información de la oferta requerida a partir de su id",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *           name="id",
     *           description="Oferta id",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/OfertaResource")
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
        $oferta = Ofertas::findOrFail($id);
        $user = Auth::user();

        if($user->rol === 'administrador') {
            return response()->json(new OfertaResource($oferta), 200);
        } elseif ($user->rol === 'responsable') {
            $ciclosResponsable = $user->ciclosComoResponsable->pluck('id')->toArray();
            if(count(array_intersect($ciclosResponsable,$oferta->ciclos->pluck('id')->toArray())) > 0){
                return response()->json(new OfertaResource($oferta), 200);
            }
        } elseif ($user->rol === 'empresa' && $oferta->empresa->id === $user->id){
            return response()->json(new OfertaResource($oferta), 200);
        } elseif($user->rol === 'alumno' && $oferta->estado === 'activa' && $oferta->validado){
            $alumno = Alumnos::findOrFail($user->id);
            $ciclosAlumno = $alumno->ciclos->pluck('id')->toArray();
            if(count(array_intersect($ciclosAlumno,$oferta->ciclos->pluck('id')->toArray())) > 0){
                return response()->json(new OfertaResource($oferta), 200);
            }
        }

    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *      path="/api/ofertas/{id}",
     *      operationId="updateOferta",
     *      tags={"Ofertas"},
     *      summary="Actualizar datos de la oferta",
     *      description="Devuelve los datos actualizados de la oferta",
     *     security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="Id de la oferta",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *               @OA\Property(property="descripcion", type="string", example="Se ofrece puesto de pinche de cocina en restaurante de Alcoi"),
     *               @OA\Property(property="duracion", type="integer", example="2"),
     *               @OA\Property(property="contacto", type="string", example="Joana Mira Martinez"),
     *               @OA\Property(property="metodoInscripcion", type="string", example="email"),
     *               @OA\Property(property="email", type="string", example="user1@mail.com"),
     *               @OA\Property(property="password", type="string", example="PassWord12345"),
     *               @OA\Property(property="ciclos", type="array",
     *                  @OA\Items(
     *                      type="object",
     *                      @OA\Property(property="idCiclo", type="integer", example=1)
     *                  )
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *           response=202,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/OfertaResource")
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
     *
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
    /**
     * @OA\Delete(
     *      path="/api/ofertas/{id}",
     *      operationId="deleteOferta",
     *      tags={"Ofertas"},
     *      summary="Eliminar una oferta registrada",
     *      description="Elimina el registro de la oferta y no devuelve nada",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter(
     *          name="id",
     *          description="ID oferta",
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

    /**
     * @OA\Post(
     *      path="/api/ofertas/inscribirse/{idOferta}/{idUsuario}",
     *      operationId="inscribirserOferta",
     *      tags={"Ofertas"},
     *      summary="Inscripciómn de un usuario a una oferta",
     *      description="Devuelve una frase confirmando la inscripicón correcta",
     *      security={ {"apiAuth": {} }},
     *      @OA\Parameter (
     *          name="idOferta",
     *          description="ID oferta",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *        ),
     *     @OA\Parameter (
     *           name="idUsuario",
     *           description="ID usuario del alumno",
     *           required=true,
     *           in="path",
     *           @OA\Schema(
     *               type="integer"
     *           )
     *         )
     *  ,
     *      @OA\Response(
     *           response=200,
     *           description="Successful operation"
     *        ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated"
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */

    public function inscribirse(int $idOferta, int $idAlumno){
        try {
            $oferta = Ofertas::findOrFail($idOferta);
            $alumno = Alumnos::findOrFail($idAlumno);

            $oferta->alumnos()->attach($alumno);
            return response()->json('Se ha apuntado correctamente a la oferta ',200);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function desinscribirse(int $idOferta, int $idAlumno){
        try {
            $oferta = Ofertas::findOrFail($idOferta);
            $alumno = Alumnos::findOrFail($idAlumno);
    
            $oferta->alumnos()->detach($alumno);
            return response()->json('Se ha desapuntado correctamente de la oferta', 200);
    
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/ofertas/candidatos/{idOferta}",
     *      operationId="getCandidatosList",
     *      tags={"Ofertas"},
     *      summary="Pedir la lista de candidadatos inscritos a la oferta determinada",
     *      description="Devuelve la lista de todos los candidatos inscritos",
     *      security={ {"apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/AlumnoResource")
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


    public function candidatos(int $id){
        try {

            $oferta = Ofertas::findOrFail($id);
            return new AlumnoCollection($oferta->alumnos);

        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/ofertas/inscritasAlumno/",
     *      operationId="getOfertasAlumno",
     *      tags={"Ofertas"},
     *      summary="Pedir la lista de ofertas a las que se ha inscrito el alumno autenticado",
     *      description="Devuelve la lista de todas las ofertas a las que se ha inscrito",
     *      security={ {"apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/OfertaResource")
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

    public function ofertasAlumnoInscrito() {
        $user = Auth::user();
        if($user->rol === 'alumno'){
            $alumno = Alumnos::findOrFail($user->id);
            try {
                $ofertas = $alumno->ofertas;
            } catch(Exception $e){
                return response()->json($e->getMessage(), 500);
            }
        }
        return new OfertaCollection($ofertas);
    }
}
