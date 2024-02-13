<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ofertas;
use Illuminate\Support\Facades\Mail;
use App\Mail\PrologaMail;

class PrologaEmail extends Command
{
    protected $signature = 'send:prologaemail';

    protected $description = 'Email para que la oferta de la empresa siga activa';

    public function handle()
    {
        $ofertas = Ofertas::where('estado', 'activa')
                     ->where('created_at', '<=', now()->subDays(30))
                     ->get();
        print($ofertas);
        foreach ($ofertas as $oferta) {
            Mail::to($oferta->empresas->user->email)->send(new PrologaMail($oferta));
        }
    }
}