<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Empresas;
use App\Models\User;
use App\Notifications\CambiarContrasenyaNotification;

class EmpresasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresas::paginate(10);
        return view('empresas.index', compact('empresas'));
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
        $empresa = Empresas::findOrFail($id);
        return view('empresas.show', compact('empresa'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $empresa = Empresas::findOrFail($id);

        return view('empresas.edit', compact('empresa'));
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
        $empresa = Empresas::find($id);
        $empresa->delete();
        $user = User::find($id);
        $user->delete();

    }
}
