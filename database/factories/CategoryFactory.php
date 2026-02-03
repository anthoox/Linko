<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => ucfirst($this->faker->words(2, true)),
            'icon' => $this->faker->randomElement(['heroicon-o-home', 'heroicon-o-user', 'heroicon-o-cog', 'heroicon-o-shopping-cart']),
            // Nota: created_at y updated_at no son necesarios, Laravel los pone solos
        ];
    }
}
