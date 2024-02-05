<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    protected static ?string $password;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(99)->create();
        User::factory()->count(1)->administrator()->create();

        $response = Http::get('https://swapi.dev/api/people/');

        if ($response->successful()) {
            $data = $response->json();



            foreach ($data['results'] as $user){
                User::create([
                    'name' => $user['name'],  
                    'email' => str_replace(' ','',$user['name'].'@gmail.com'),
                    'email_verified_at' => now(),
                    'password' => static::$password ??= Hash::make('password'),   
                    'administrador' => false,
                    'remember_token' => Str::random(10),
    
                ]);
            }
        } else {
            print("Error en el api star wars");
        }

        

    }

    public function getStarWarsCharacters()
    {
        $response = Http::get('https://swapi.dev/api/people/');

        if ($response->successful()) {
            $data = $response->json();
        } else {
            print("Error en el api star wars");
        }
    }

}
