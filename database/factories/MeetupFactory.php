<?php

namespace Database\Factories;

use App\Models\Meetup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meetup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->numberBetween($min = 1, $max = 50),
            'slug' => $this->faker->unique()->userName,
            'name' => $this->faker->sentence($nbWords = 2, $variableNbWords = true),
            'tagline' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'location' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'description' => $this->faker->sentence($nbWords = 15, $variableNbWords = true),
            'cover' => 'https://i.imgur.com/QuZ5H7D.jpg',
            'date' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = '+5 days'),
            'created_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at' => $this->faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ];
    }
}
