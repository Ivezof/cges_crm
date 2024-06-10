<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create();
        return [
            'fio' => $faker->name(),
            'email' => $faker->email(),
            'phone' => $faker->phoneNumber(),
            'telegram' => '@' . $faker->userName(),
            'email_verify_hashcode' => Str::random(),
            'email_verify' => true
        ];
    }
}
