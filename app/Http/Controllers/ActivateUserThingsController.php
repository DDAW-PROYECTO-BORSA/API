<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ActivateUserThingsController extends Controller
{
    public function activarCuenta($id) {
        $user = User::findOrFail($id);
        $user->activado = 1;
        $user->save();
        return view('notificaciones.validarCorreo', compact('user'));

    
    }
}
