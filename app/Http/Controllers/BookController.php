<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\AltaLlibre;
use App\Mail\PurchaseComfirmationMail;
use Illuminate\Support\Facades\Mail;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = "";
        $books = Book::where('admes', true)
        ->paginate(10);
        return view('books.index', compact('books'));
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modules = Module::all();
        return view('books.create', compact('modules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $book = new Book();
        $book->idModule = $request->get('idModule');
        $book->publisher = $request->get('publisher');
        $book->pages = $request->get('pages');
        $book->price = $request->get('price');
        $book->status = $request->get('status');

        $book->idUser = Auth::user()->id;
        $book->save();

        $admin = User::where('administrador', true)->first();
        $admin->notify(new AltaLlibre($book));


        return redirect()->route('books.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::findOrFail($id);
        return view('books.show', compact('book'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $book = Book::findOrFail($id);
        $modules = Module::all();

        return view('books.edit', compact('book', 'modules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::findOrFail($id);
        $book->idModule = $request->get('idModule');
        $book->publisher = $request->get('publisher');
        $book->pages = $request->get('pages');
        $book->price = $request->get('price');
        $book->status = $request->get('status');
        $book->save();

        return redirect()->route('books.show', [$book->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index');
    }


    public function admitirLibro($id)
{
    $book = Book::findOrFail($id);
    $book->admes = true;
    $book->save();
    return redirect()->route('books.index');
}

    public function comprarLibro($id)
{
    $book = Book::findOrFail($id);
    $book->soldDate = date('Y-m-d');
    $book->save();
    $admin = User::where('administrador', true)->first();

    Mail::to($admin->email)->send(new PurchaseComfirmationMail($book));

    return redirect()->route('books.index');
}

public function myBooks()
{        
    $books = Book::where('idUser', Auth::user()->id)
    ->where('admes', true)
    ->paginate(10);
    return view('books.loggedIndex', compact('books'));
}
}
