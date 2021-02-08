<?php

namespace Database\Factories;

use App\Models\ImgProducto;
use App\Models\Producto;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ImgProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ImgProducto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $defaultImages = [
            'img/defaultimages/consola.jpg',
            'img/defaultimages/tv.jpg',
            'img/defaultimages/mueble.jpg',
            'img/defaultimages/ropa.jpg',
        ];
        return [
            'nombre' => $defaultImages[rand(0, count($defaultImages) -1 )],
            'producto_id' => $this->faker->unique()->numberBetween(1, Producto::all()->count()),
        ];
    }
}
