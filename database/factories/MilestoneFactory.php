<?php

namespace Database\Factories;

use App\Models\Milestone;
use Illuminate\Database\Eloquent\Factories\Factory;

class MilestoneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Milestone::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'name' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
            'start_date' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            'end_date' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
        ];
    }
}
