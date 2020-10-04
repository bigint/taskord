<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        DB::table('questions')->insert([
            'user_id' => 1,
            'title' => 'Hello, World!',
            'body' => 'Hello, World!',
            'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
        ]);
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
