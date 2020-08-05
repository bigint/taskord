<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'firstname' => 'Dabbit',
            'username' => 'dabbit',
            'company' => 'Taskord',
            'bio' => 'Dabbing with Code',
            'email' => 'dabbit@tuta.io',
            'avatar' => 'https://github.com/dabbit.png',
            'password' => Hash::make('test'),
            'reputation' => 550,
            'website' => 'https://github.com/dabbit',
            'twitter' => 'evildabbit',
            'twitch' => 'evildabbit',
            'github' => 'dabbit',
            'telegram' => 'evildabbit',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
