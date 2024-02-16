<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alumnos;
use App\Models\User;
use App\Notifications\CambiarContrasenyaNotification;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ciclosId = auth()->user()->ciclosComoResponsable->pluck('id');
        $alumnos = Alumnos::whereNotNull("apellido")->whereHas('ciclos', function ($query) use ($ciclosId) {
            $query->whereIn('id', $ciclosId);
        })->paginate(10);

        return view('alumnos.index', compact('alumnos'));
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
        $alumno = Alumnos::findOrFail($id);
        return view('alumnos.show', compact('alumno'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $alumno = Alumnos::findOrFail($id);

        return view('alumnos.edit', compact('alumno'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->password = $request->get('password');
        $user->save();

        return "Tu contraseña se ha actualizado correctamente";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
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
    }
}
