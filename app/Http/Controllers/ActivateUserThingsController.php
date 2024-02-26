<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ciclos;
use App\Models\Alumnos;
use App\Models\Ofertas;
use App\Mail\NuevaOfertaMail;
use Illuminate\Support\Facades\Mail;


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

        if ($alumno && $alumno->ciclos()->where('idCiclo', $cicloId)->first()->pivot->validado == 0) {
            $alumno->ciclos()->updateExistingPivot($cicloId, ['validado' => 1]);
            return view('notificaciones.validarCiclo', compact('alumno', 'ciclo'));
        } else{
            return "Este ciclo ya ha sido validado por otro representante o administrador";
        }
    }

    public function validarOferta($id) {
        $oferta = Ofertas::findOrFail($id);
        if($oferta->validado == 1){
            return "Esta oferta ya ha sido validada por otro responsable";
        } else {
            $oferta->validado = 1;
            $oferta->estado = "activa";
            $oferta->save();

            $ciclosOferta = $oferta->ciclos;
            foreach ($ciclosOferta as $cicloOferta) {
                foreach ($cicloOferta->alumnos as $alumnoOferta) {
                    Mail::to($alumnoOferta->user->email)->send(new NuevaOfertaMail($oferta));
                    sleep(1);

                }
            }
            return view('notificaciones.validarOferta', compact('oferta'));

        }
    }
}
