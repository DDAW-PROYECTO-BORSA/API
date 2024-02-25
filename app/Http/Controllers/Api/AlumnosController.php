<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AlumnoRequest;
use App\Http\Resources\AlumnoCollection;
use App\Http\Resources\AlumnoResource;
use App\Models\Alumnos;
use App\Models\User;
use App\Models\Ciclos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ActivarCuentaNotification;
use App\Notifications\ValidarCiclosNotification;


class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * @OA\Get(
     *      path="/api/alumnos",
     *      operationId="getAlumnosList",
     *      tags={"Alumnos"},
     *      summary="Pedir la lista de alumnos",
     *      description="Devuelve la lista de todos los alumnos registrados",
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
    public function index()
    {
        $alumnos = Alumnos::all();
        return new AlumnoCollection($alumnos);
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * @OA\Post(
     *      path="/api/alumnos",
     *      operationId="storeAlumno",
     *      tags={"Alumnos"},
     *      summary="Guarda un nuevo usuario con el rol de alumno y crea un registro de alumno",
     *      description="Devuelve los datos del alumno guardado",
     *      security={ {"apiAuth": {} }},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"name","apellidos","direccion","email","CV","password","ciclosA"},
     *              @OA\Property(property="name", type="string", example="Pepe"),
     *              @OA\Property(property="apellidos", type="string", example="Llopis Carbonell"),
     *              @OA\Property(property="direccion", type="string", example="C/Sant Nicolau, 36, 03802 Alcoi, Alacant"),
     *              @OA\Property(property="email", type="string", example="user1@mail.com"),
     *              @OA\Property(property="CV", type="string", example="www.myCV.com"),
     *              @OA\Property(property="password", type="string", example="PassWord12345"),
     *              @OA\Property(property="ciclosA", type="array",
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="id", type="integer", example=1),
     *                  @OA\Property(property="ciclo_id", type="integer", example=1),
     *                  @OA\Property(property="finalizacion", type="string", example="2023-12-01 12:00:00")
     *              )
     *          )
     *      )
     *  ),
     *      @OA\Response(
     *           response=200,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/AlumnoResource")
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
    public function store(AlumnoRequest $request)
    {
        try {
            $admin = User::where('rol', 'administrador')->first();
            // Crear usuario
            if(User::where('email', $request->email)->first() == null){
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->direccion = $request->direccion;
                $user->rol = 'alumno';
                $user->save();
                // Crear el alumno asociada al usuario
                $alumno = new Alumnos();
                $alumno->apellido = $request->apellido;
                $alumno->cv = $request->cv;

                // Guardar el alumno asociada al usuario
                $user->alumno()->save($alumno);
                $alumno = Alumnos::findOrFail($user->id);

                $user->notify(new ActivarCuentaNotification($user));

                if ($request->ciclosA){
                    foreach ($request->ciclosA as $cicloA) {
                        $ciclo = Ciclos::findOrFail($cicloA['id']);
                        $alumno->ciclos()->attach($ciclo->id, [
                            'finalizacion' => $cicloA['finalizacion'],
                        ]);
                        $ciclo->usuarioResponsable->notify(new ValidarCiclosNotification($alumno, $ciclo));
                        $admin->notify(new ValidarCiclosNotification($alumno, $ciclo));
                    }
                }
                return response()->json(new AlumnoResource($alumno),201);
            } else {
                return response()->json('Error: email ya registrado',400);
            }

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * @OA\Get(
     *      path="/api/alumnos/{id}",
     *      operationId="getAlumnoById",
     *      tags={"Alumnos"},
     *      summary="Pedir la información de un alumno",
     *      description="Devuelve la información del alumno requerido a partir de su id de usuario",
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
        $alumno = Alumnos::findOrFail($id);
        return response()->json(new AlumnoResource($alumno), 200);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * @OA\Put(
     *      path="/api/alumnos/{id}",
     *      operationId="updateAlumno",
     *      tags={"Alumnos"},
     *      summary="Actualizar datos del alumno",
     *      description="Devuelve los datos actualizados del alumno",
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
     *          @OA\JsonContent(ref="#/components/schemas/AlumnoRequest")
     *      ),
     *     @OA\Response(
     *           response=202,
     *           description="Successful operation",
     *           @OA\JsonContent(ref="#/components/schemas/AlumnoResource")
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

    public function update(AlumnoRequest $request, int $id)
    {
        $admin = User::where('rol', 'administrador')->first();

        $alumno = Alumnos::findOrFail($id);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->direccion = $request->direccion;
        $user->update();

        $alumno->apellido = $request->apellido;
        $alumno->cv = $request->cv;
        $alumno->update();

        if ($request->ciclosA) {
            foreach ($request->ciclosA as $cicloA) {
                $ciclo = Ciclos::findOrFail($cicloA['id']);
                $alumno->ciclos()->attach($ciclo->id, [
                    'finalizacion' => $cicloA['finalizacion'],
                ]);
                $ciclo->usuarioResponsable->notify(new ValidarCiclosNotification($alumno, $ciclo));
                $admin->notify(new ValidarCiclosNotification($alumno, $ciclo));
            }
            return response()->json(new AlumnoResource($alumno), 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    /**
     * @OA\Delete(
     *      path="/api/alumnos/{id}",
     *      operationId="deleteAlumno",
     *      tags={"Alumnos"},
     *      summary="Eliminar un alumno registrado",
     *      description="Elimina el registro del alumno y no devuelve nada",
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

    public function destroy(int $id)
    {
        try{
            $alumno = Alumnos::findOrFail($id);
            $user = User::findOrFail($id);
            $user->name = null;
            $user->email = null;
            $user->password = null;
            $user->direccion = null;
            $user->activado = 0;
            $user->update();

            $alumno->apellido = null;
            $alumno->cv = null;
            $alumno->update();

            return response()->json('', 204);

        } catch (Exception $e) {

            return response()->json($e, 500);
        }


    }
}
