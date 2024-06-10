<?php

namespace Database\Factories;

use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws Exception
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'client_id' => 14,
            'description' => Str::random(10),
            'address' => Str::random(15),
            'budget' => random_int(50000, 100000),
            'endOrder' => '2024-06-06 16:12:40',
            'spent' => random_int(1, 49999),
            'status' => 4,
            'created_at' => $faker->dateTimeBetween('-30 days', 'now')
        ];
    }
}
