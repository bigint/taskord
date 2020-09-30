<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        DB::table('products')->insert([
            'slug' => 'taskord',
            'name' => 'Taskord',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'description' => 'Get things done socially with Taskord',
            'user_id' => 1,
            'website' => 'https://taskord.com',
            'twitter' => $faker->userName,
            'github' => $faker->userName,
            'producthunt' => $faker->userName,
            'launched' => $faker->boolean($chanceOfGettingTrue = 50),
            'launched_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
        ]);
        foreach (range(1, 1000) as $index) {
            DB::table('products')->insert([
                'slug' => $faker->unique()->userName,
                'name' => $faker->firstName,
                'avatar' => 'https://avatar.tobi.sh/'.$faker->userName.'.svg?text='.$faker->emoji,
                'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'website' => 'https://gitlab.com',
                'twitter' => $faker->userName,
                'github' => $faker->userName,
                'producthunt' => $faker->userName,
                'launched' => $faker->boolean($chanceOfGettingTrue = 50),
                'launched_at' => $faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
                'created_at' => $faker->dateTimeBetween($startDate = '-600 days', $endDate = 'now'),
            ]);
        }
    }
}
