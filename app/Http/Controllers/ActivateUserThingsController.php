<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ciclos;
use App\Models\Alumnos;
use App\Models\Ofertas;

class ActivateUserThingsController extends Controller
{
    public function activarCuenta($id) {
        $user = User::findOrFail($id);
        $user->activado = 1;
        $user->save();
        return view('notificaciones.validarCorreo', compact('user'));

    
    }

    public function validarCiclo($alumnoId, $cicloId) {
        $alumno = Alumnos::findOrFail($alumnoId);
        $ciclo = Ciclos::findOrFail($cicloId);

        if ($alumno && $alumno->ciclos()->where('idCiclo', $cicloId)->exists()) {
            $alumno->ciclos()->updateExistingPivot($cicloId, ['validado' => 1]);
            return view('notificaciones.validarCiclo', compact('alumno', 'ciclo'));
        }           
    }

    public function validarOferta($id) {
        $oferta = Ofertas::findOrFail($id);
        if($oferta->validado === 1){
            return "Esta oferta ya ha sido validada por otro responsable";
        } else {
            $oferta->validado = 1;
            $oferta->estado = "activa";
            $oferta->save();
            return view('notificaciones.validarOferta', compact('oferta'));

        }
    }
}
