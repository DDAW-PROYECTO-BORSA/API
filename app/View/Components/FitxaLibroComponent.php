<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Book;

class FitxaLibroComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct($book)
    {
        $this->book = Book::findOrFail($book);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.fitxa-libro-component', ['book' => $this->book]);
    }
}
