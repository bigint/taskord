<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'title' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'body' => $this->faker->sentence($nbWords = 60, $variableNbWords = true),
            'patronOnly' => $this->faker->boolean($chanceOfGettingTrue = 10),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ];
    }
}
