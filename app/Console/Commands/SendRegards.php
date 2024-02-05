<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Regards;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class SendRegards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:regards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $usersWithSales = User::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('sales')
                ->whereRaw('sales.idUser = users.id');
        })->get();        foreach ($usersWithSales as $user) {
            Mail::to($user->email)->send(new Regards($user));
            print("Correo enviado a ". $user->email);
        }

    }
}
