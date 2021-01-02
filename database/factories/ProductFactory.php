<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'slug' => $this->faker->unique()->userName,
            'name' => $this->faker->firstName,
            'avatar' => 'https://avatar.tobi.sh/'.$this->faker->userName.'.svg?text='.$this->faker->emoji,
            'description' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'website' => 'https://gitlab.com',
            'twitter' => $this->faker->userName,
            'repo' => 'https://github.com/taskord/taskord',
            'producthunt' => $this->faker->userName,
            'launched' => $this->faker->boolean($chanceOfGettingTrue = 50),
            'launched_at' => $this->faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
        ];
    }
}
