<?php

namespace Database\Seeders;

use App\Models\Familias;
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
        $familias = json_decode(file_get_contents($jsonFile), true);

        foreach ($familias as $familia) {
            Familias::create([
                'id' => $familia['id'],
                'cliteral' => $familia['cliteral'],
                'vliteral' => $familia['vliteral'],
                'depcurt' => $familia['depcurt']
            ]);
        }
    }
}
