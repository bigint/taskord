<?php

namespace Database\Factories;

use App\Models\ProductUpdate;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductUpdateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductUpdate::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'product_id' => $this->faker->numberBetween($min = 1, $max = 100),
            'title' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'body' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
        ];
    }
}
