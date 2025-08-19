<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "nombre" => $this->faker->sentence(2),
            "precio" => $this->faker->randomFloat(2, 10, 1000),
            "descripcion" => $this->faker->sentence(10),
            "stock" => $this->faker->randomNumber(2),
        ];
    }
}
