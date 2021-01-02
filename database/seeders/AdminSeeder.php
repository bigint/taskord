<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
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
    public function run(Faker $faker)
    {
        DB::table('users')->insert([
            'username' => 'test',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'company' => 'Taskord',
            'location' => 'Internet',
            'bio' => 'Test the taskord',
            'email' => 'test@taskord.com',
            'avatar' => 'https://contractize.com/wp-content/uploads/2017/02/Robot.jpg',
            'password' => Hash::make('test'),
            'twitter' => 'test',
            'twitch' => 'test',
            'telegram' => 'test',
            'github' => 'test',
            'youtube' => 'test',
            'reputation' => 0,
            'website' => 'https://taskord.test',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => '2020-04-20 13:14:01',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'test',
            'username' => 'unverified',
            'company' => 'Taskord',
            'bio' => 'Test the taskord',
            'email' => 'unverified@taskord.com',
            'avatar' => 'https://contractize.com/wp-content/uploads/2017/02/Robot.jpg',
            'password' => Hash::make('test'),
            'reputation' => 0,
            'website' => 'https://taskord.test',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => '2020-04-20 13:14:01',
        ]);

        DB::table('users')->insert([
            'firstname' => 'Admin',
            'username' => 'admin',
            'company' => 'Taskord',
            'email' => 'taskord+test@icloud.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'password' => Hash::make('admin'),
            'website' => 'https://taskord.com',
            'twitter' => 'taskord',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'api_token' => 'Ajfow3xVyqqHD3lRFirc6bRD8xzPov65XdXDbevR6ytxKS3pXoINUgIVRNpc',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => $faker->dateTimeBetween($startDate = '-5 days', $endDate = 'now'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'firstname' => 'Suspended',
            'username' => 'suspended',
            'company' => 'Taskord',
            'bio' => 'Test the taskord',
            'email' => 'suspended@taskord.com',
            'avatar' => 'https://contractize.com/wp-content/uploads/2017/02/Robot.jpg',
            'password' => Hash::make('test'),
            'reputation' => 0,
            'website' => 'https://taskord.test',
            'onlyFollowingsTasks' => false,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'isFlagged' => true,
            'isSuspended' => true,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => '2020-04-20 13:14:01',
        ]);
    }
}
