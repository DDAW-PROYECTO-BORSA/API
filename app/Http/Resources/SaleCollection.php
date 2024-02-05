<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Models\User;
use App\Models\Book;

class SaleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($sale) {
                return [
                    'book' => Book::findOrFail($sale->idBook), 
                    'user' => User::findOrFail($sale->idUser),
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
