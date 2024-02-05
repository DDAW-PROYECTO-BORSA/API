<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Family;
use Storage;


class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = Storage::disk("public")->get('families.json');
        $data = json_decode($families, true);

        foreach ($data[2]['data'] as $item){
            Family::create([
                'id' => $item['id'],          
                'cliteral' => $item['cliteral'],  
                'vliteral' => $item['vliteral'] 
            ]);
        }
    }
}
