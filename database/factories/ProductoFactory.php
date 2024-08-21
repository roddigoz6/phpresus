<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    protected $model = Producto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nombre' => $this->faker->randomElement(['Martillo ', 'Cemento ', 'Pala ', 'Llave inglesa ', 'Caladora ', 'Madera ', 'Taladro ', 'Atornillador ', 'Cola ', 'Comba ', 'Sierra ', 'Alambre ']) . $this->faker->numberBetween(1, 100),
            'precio' => $this->faker->randomFloat(2, 5.99, 19.99),
            'leyenda' => $this->faker->sentence,
            'stock' => $this->faker->numberBetween(1,20),
            'tipo' => $this->faker->randomElement(['articulo', 'visita']),
            'eliminado' => false,

        ];
    }
}
