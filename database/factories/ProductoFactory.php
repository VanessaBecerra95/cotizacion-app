<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    protected $imagenes = [
        'imagen1.webp',
        'imagen2.webp',
        'imagen3.webp',
        'imagen4.webp',
        'imagen5.webp',
        'imagen6.webp',
        'imagen7.webp',
        'imagen8.webp',
        'imagen9.webp',
        'imagen10.webp'
    ];

    protected static $imageIndex = 0;

    public function definition(): array
    {
        if (static::$imageIndex >= count($this->imagenes)) {
            static::$imageIndex = 0;
        }

        $imagePath = 'products/' . $this->imagenes[static::$imageIndex];
        static::$imageIndex++;

        return [
            'nombre' => $this->faker->unique()->words(2, true),
            'descripcion' => $this->faker->sentence(6),
            'precio' => $this->faker->numberBetween(100, 10000),
            'stock' => $this->faker->numberBetween(0, 300),
            'image_path' => $imagePath,
        ];
    }
}
