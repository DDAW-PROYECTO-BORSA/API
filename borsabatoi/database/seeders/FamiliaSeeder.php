<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class FamiliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = Storage::disk('public')->path('departamentos.json');
        $families = json_decode(file_get_contents($jsonFile), true);

        foreach ($families as $family) {
            Familia::create($family);
        }
    }
}
