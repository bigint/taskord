<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MeetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        foreach (range(1, 30) as $index) {
            DB::table('meetups')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'slug' => $faker->unique()->userName,
                'name' => $faker->sentence($nbWords = 2, $variableNbWords = true),
                'tagline' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'address' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'description' => $faker->sentence($nbWords = 15, $variableNbWords = true),
                'cover' => 'https://pbs.twimg.com/profile_banners/864525927438536707/1598315700/1500x500',
                'date' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = '+5 days'),
                'created_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
                'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            ]);
        }
    }
}
