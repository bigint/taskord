<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoadTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (range(1, 1000000) as $index) {
            echo "$index \n";
            DB::table('tasks')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'product_id' => $faker->numberBetween($min = 1, $max = 50),
                'source' => 'Taskord for Web',
                'task' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'done' => $faker->boolean($chanceOfGettingTrue = 50),
                'done_at' => $faker->dateTimeBetween($startDate = '-10000 days', $endDate = '-5 days'),
                'created_at' => $faker->dateTimeBetween($startDate = '-5000 days', $endDate = 'now'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-5000 days', $endDate = 'now'),
            ]);
        }
    }
}
