<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmpresaRequest;
use App\Http\Resources\EmpresaCollection;
use App\Http\Resources\EmpresaResource;
use App\Models\Empresas;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresas::all();
        return new EmpresaCollection($empresas);
    }

    /**
     * Store a newly created resource in storage.
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

            return response()->json(new EmpresaResource($empresa),201);
            }
           
        } catch (Exception $e) {

            return response()->json($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $empresa = Empresas::findOrFail($id);
        return response()->json(new EmpresaResource($empresa), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpresaRequest $request, int $id)
    {
        $empresa = Empresas::findOrFail($id);
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->direccion = $request->direccion;
        $user->update();

        $empresa->CIF = $request->CIF;
        $empresa->contacto = $request->contacto;
        $empresa->web = $request->web;
        $empresa->update();

        return response()->json(new EmpresaResource($empresa),200);
    }

    /**
     * Remove the specified resource from storage.
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
