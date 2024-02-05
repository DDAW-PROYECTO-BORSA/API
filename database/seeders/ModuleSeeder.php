<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use Storage;


class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Storage::disk("public")->get('modules.json');
        $data = json_decode($modules, true);

        foreach ($data[2]['data'] as $item){
            Module::create([
                'code' => $item['code'],        
                'cliteral' => $item['cliteral'],  
                'vliteral' => $item['vliteral'],
                'idCycle' => $item['idCycle'],    
            ]);
        }
    }
}
