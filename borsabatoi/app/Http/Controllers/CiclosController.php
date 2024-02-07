<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciclos;
use App\Models\User;

class CiclosController extends Controller
{
    public function index()
    {
        $ciclos = Ciclos::paginate(10);
        return view('ciclos.index', compact('ciclos'));
    }

    public function create()
    {
        //return view('ciclos.create');
    }

    public function store(Request $request)
    {
       // metodos
    }

    public function show(Ciclos $ciclo)
    {
        return view('ciclos.show', compact('ciclo'));
    }

    public function edit(Ciclos $ciclo)
    {
        $responsables = User::where('rol', 'responsable')->inRandomOrder()->get(); 
        
        return view('ciclos.edit', compact('ciclo', 'responsables'));
    }

    public function update(Request $request, Ciclos $ciclo)
    {

        $ciclo = Ciclos::findOrFail($ciclo->id);
        $ciclo->responsable = $request->get('responsable');
        $ciclo->save();

        return redirect()->route('ciclos.index')
                         ->with('success', 'Ciclo actualizado exitosamente.');
    }

    public function destroy(Ciclos $ciclo)
    {
        //$ciclo->delete();
        //return redirect()->route('ciclos.index')
          //               ->with('success', 'Ciclo eliminado exitosamente.');
    }
}