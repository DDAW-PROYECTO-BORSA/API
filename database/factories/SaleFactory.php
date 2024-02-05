<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Book;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $soldDate = $this->faker->dateTimeBetween('-1 years', 'now');
        $book = Book::factory()->create([
            'soldDate' => $soldDate->format('Y-m-d'), // Data de l'any passat
        ]);

        return [
            'idBook' => $book->id,
            'idUser' => User::inRandomOrder()->first()->id,
        ];
    }
}
