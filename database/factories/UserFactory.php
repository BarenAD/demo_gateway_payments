<?php

namespace Database\Factories;

use App\Models\Lang;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sex = (bool)rand(0,1);
        return [
            'last_name' => fake('ru_RU')->lastName($sex ? 'male' : 'female'),
            'first_name' => fake('ru_RU')->firstName($sex ? 'male' : 'female'),
            'birthdate' => fake()->dateTimeBetween('-40 years', '-10 years')->format('Y-m-d'),
            'sex' => $sex,
            'email' => fake()->unique()->email(),
            'lang_id' => Lang::query()->inRandomOrder()->first()->id,
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Hash::make(Str::uuid()),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
