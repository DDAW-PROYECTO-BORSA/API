<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Models\User;
use App\Models\Module;

class BookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($book) {
                return [
                    'id' => $book->id,
                    'user' => User::findOrFail($book->idUser)->only(['id', 'name', 'email']), // Modify as needed
                    'module' => Module::where('code', $book->idModule)->firstOrFail()->only(['id', 'name']), // Modify as needed
                    'publisher' => $book->publisher,
                    'price' => $book->price,
                    'pages' => $book->pages,
                    'status' => $book->status,
                    'photo' => $book->photo,
                    'soldDate' => $book->soldDate,
                    'comments' => $book->comments,
                ];
            }),
            'meta' => [
                'current_page' => $this->currentPage(),
                'total_pages' => $this->lastPage(),
                'per_page' => $this->perPage(),
                'total' => $this->total(),
            ],
            'links' => [
                'prev' => $this->previousPageUrl(),
                'next' => $this->nextPageUrl()
            ],
            'status' => 'success'
        ];
    }
}