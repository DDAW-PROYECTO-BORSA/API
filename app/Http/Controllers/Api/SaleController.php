<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Resources\SaleCollection;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::paginate(10);
        return new SaleCollection($sales);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $sale = new Sale();
        $sale->idBook = $request->get('idBook');
        $sale->idUser = $request->get('idUser');
        $book->save();
        return response()->json($sale, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::findOrFail($id);
        return response()->json($sale, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->bookId = $request->bookId;
        $sale->userId = $request->userId;
        $sale->save();
        return response()->json($sale);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        $sale->delete();
        return response()->json(null, 204);
    }
}
