<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
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
            DB::table('tasks')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'product_id' => $faker->numberBetween($min = 1, $max = 100),
                'task' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'done' => $faker->boolean($chanceOfGettingTrue = 50),
                'done_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
                'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            ]);
        }
        foreach (range(1, 1000) as $index) {
            DB::table('tasks')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'product_id' => $faker->numberBetween($min = 1, $max = 100),
                'task' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'done' => $faker->boolean($chanceOfGettingTrue = 50),
                'done_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
                'created_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-30 days', $endDate = '-5 days'),
            ]);
        }
    }
}
