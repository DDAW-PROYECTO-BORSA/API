<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(FamiliaSeeder::class);
        $this->call(UsuarioSeeder::class);
        $this->call(AlumnosSeeder::class);
        $this->call(EmpresaSeeder::class);
        $this->call(CicloSeeder::class);
        $this->call(AlumnosCicloSeeder::class);
        $this->call(OfertaSeeder::class);
        $this->call(OfertaCicloSeeder::class);
        $this->call(OfertaAlumnoSeeder::class);
    }
}
