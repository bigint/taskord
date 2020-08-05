<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('products')->insert([
            'slug' => 'taskord',
            'name' => 'Taskord',
            'avatar' => 'https://github.com/taskord.png',
            'description' => 'Get things done socially with Taskord',
            'user_id' => 1,
            'website' => 'https://github.com/dabbit',
            'twitter' => $faker->userName,
            'github' => $faker->userName,
            'producthunt' => $faker->userName,
            'launched' => $faker->boolean($chanceOfGettingTrue = 50),
            'launched_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
            'created_at' => $faker->dateTimeBetween($startDate = '-2 days', $endDate = 'now'),
        ]);
        foreach (range(1, 2000) as $index) {
            DB::table('products')->insert([
                'slug' => $faker->unique()->userName,
                'name' => $faker->firstName,
                'avatar' => 'https://avatar.tobi.sh/'.$faker->userName.'.svg?text='.$faker->emoji,
                'description' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'user_id' => $faker->numberBetween($min = 1, $max = 50),
                'website' => 'https://github.com/dabbit',
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
