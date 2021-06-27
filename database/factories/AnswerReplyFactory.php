<?php

namespace Database\Factories;

use App\Models\AnswerReply;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerReplyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AnswerReply::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'answer_id' => $this->faker->numberBetween($min = 1, $max = 100),
            'reply' => $this->faker->sentence($nbWords = 10, $variableNbWords = true),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ];
    }
}
