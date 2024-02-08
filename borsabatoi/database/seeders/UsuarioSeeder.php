<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@borsabatoi.es',
            'password' => Hash::make('adminpassword'),
            'direccion' => 'Carrer Societat Unió Musical, 8, 03802 Alcoi, Alicante',
            'rol' => 'administrador'
        ]);

        User::factory(10)->create();
    }
}
