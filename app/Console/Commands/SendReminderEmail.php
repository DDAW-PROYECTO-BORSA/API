<?php

namespace App\Console\Commands;

use App\Mail\RecordatorioActivarCuenta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendReminderEmail extends Command
{
    protected $signature = 'send:reminderemails';

    protected $description = 'Send reminder emails to users who have not validated their accounts';

    public function handle()
    {
        $users = User::where('activado', false)
                     ->where('created_at', '<=', now()->subDays(3))
                     ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new RecordatorioActivarCuenta());
        }
    }
}