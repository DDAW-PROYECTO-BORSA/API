<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Http\Resources\BookCollection;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            $books = Book::paginate(10);
            return new BookCollection($books);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try{
            $book = new Book();
            $book->idModule = $request->get('idModule');
            $book->publisher = $request->get('publisher');
            $book->pages = $request->get('pages');
            $book->price = $request->get('price');
            $book->status = $request->get('status');
            $book->idUser = $request->get('idUser');
            $book->save();
            return response()->json($book, 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
    }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try { 
            $book = Book::findOrFail($id);
            return response()->json($book, 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try { 
            $book = Book::findOrFail($id);
            $book->idModule = $request->get('idModule');
            $book->publisher = $request->get('publisher');
            $book->pages = $request->get('pages');
            $book->price = $request->get('price');
            $book->status = $request->get('status');
            $book->save();
            return response()->json($sale);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $book = Book::findOrFail($id);
            $book->delete();
            return response()->json(null, 204);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 400);
        }
    }
}
