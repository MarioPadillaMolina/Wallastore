<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Estado;
use App\Models\Categoria;
use App\Models\ImgProducto;
use App\Models\Uso;
use App\Models\User;
use Carbon\Carbon;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->word() . ' ' . $this->faker->word() . ' ' . $this->faker->word() . ' ' . $this->faker->word(),
            'precio' => $this->faker->numberBetween($min = 10, $max = 500),
            'descripcion' => $this->faker->text(),
            'estado_id' => rand(1, count(Estado::all())),
            'uso_id' => rand(1, count(Uso::all())),
            'categoria_id' => rand(1, count(Categoria::all())),
            'user_id' => rand(1, count(User::all())),
            'fecha' => $this->faker->unique()->dateTimeBetween('-10 years', 'now')
        ];
    }
}

