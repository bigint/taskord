<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'question_id' => $this->faker->numberBetween($min = 1, $max = 30),
            'answer' => $this->faker->sentence($nbWords = 30, $variableNbWords = true),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ];
    }
}
