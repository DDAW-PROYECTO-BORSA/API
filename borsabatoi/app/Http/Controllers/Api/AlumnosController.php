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
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidarCorreoMail;

class AlumnosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alumnos = Alumnos::all();
        return new AlumnoCollection($alumnos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Crear usuario
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

            Mail::to($user->email)->send(new ValidarCorreoMail($user));

            foreach ($request->ciclosA as $cicloA) {
                $ciclo = Ciclos::findOrFail($cicloA['id']);
                $alumno->ciclos()->attach($ciclo->id, [
                    'finalizacion' => $cicloA['finalizacion'],
                ]);                
                // Notificacion para validar el ciclo
            }


            return response()->json(new AlumnoResource($alumno),201);
        } catch (Exception $e) {

            return response()->json($e, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $alumno = Alumnos::findOrFail($id);
        return response()->json(new AlumnoResource($alumno), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $alumno = Alumnos::findOrFail($id);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->direccion = $request->direccion;
        $user->activado = 1;
        $user->update();

        $alumno->apellido = $request->apellido;
        $alumno->cv = $request->cv;
        $alumno->update();

        return response()->json(new AlumnoResource($alumno),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        //
    }

    public function activarCuenta($id) {
        $user = User::findOrFail($id);
        $user->activado = 1;
        $user->save();
    
    }
}
