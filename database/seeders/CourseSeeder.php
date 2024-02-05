<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;
use Storage;


class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Storage::disk("public")->get('courses.json');
        $data = json_decode($courses, true);

        foreach ($data[2]['data'] as $item){
            Course::create([
                'id' => $item['id'],        
                'cycle' => $item['cycle'],    
                'cliteral' => $item['cliteral'],  
                'vliteral' => $item['vliteral'],
                'idFamily' => $item['idFamily'] 

            ]);
        }
    }
}
