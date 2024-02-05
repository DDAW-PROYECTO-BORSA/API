<?php

namespace Database\Factories;
use App\Models\Module;
use App\Models\User;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'idUser' => User::inRandomOrder()->first()->id,
            'idModule' => Module::inRandomOrder()->first()->code,
            'publisher' => $this->faker->company,
            'price' => $this->faker->randomFloat(2, 10, 100),
            'pages' => $this->faker->numberBetween(50, 500),
            'status' => $this->faker->randomElement(['available', 'unavailable', 'archived']),
            'photo' => $this->faker->imageUrl(),
            'comments' => $this->faker->optional()->text,
            'admes' => true,
        ];
    }
}
