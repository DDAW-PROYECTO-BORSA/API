<?php

namespace Database\Seeders;

use App\Models\Ofertas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ofertas::factory()->count(30)->create();
    }
}
