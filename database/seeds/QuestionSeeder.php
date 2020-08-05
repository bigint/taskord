<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1, 50) as $index) {
            DB::table('questions')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'title' => $faker->sentence($nbWords = 15, $variableNbWords = true),
                'body' => $faker->sentence($nbWords = 60, $variableNbWords = true),
                'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            ]);
        }
    }
}
