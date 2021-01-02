<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

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
            'task' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'done' => $this->faker->boolean($chanceOfGettingTrue = 80),
            'source' => 'Taskord for Web',
            'done_at' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
        ];
    }
}
