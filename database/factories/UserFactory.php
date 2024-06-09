<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'firstname' => $this->faker->firstName,
            'middlename' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'email_verified_at' => now(),
            'birthdate' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'address' => $this->faker->address,
            'sex' => $this->faker->randomElement(['Male', 'Female']),
            'status' => $this->faker->randomElement(['Current', 'Former']),
            'phone' => $this->faker->phoneNumber,
            'role' => $this->faker->randomElement([
                "Super Admin",
                "Admin",
                "Scaler",
                "Lamesador",
                "Hornero",
                "Baker",
                "Cashier",
                "Sales Clerk",
                "Utility",
                "Not Yet Assigned"
            ]),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return $this
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
