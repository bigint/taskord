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
            'firstname' => 'test',
            'username' => 'test',
            'company' => 'Taskord',
            'bio' => 'Test the taskord',
            'email' => 'test@taskord.com',
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
        ]);

        DB::table('users')->insert([
            'firstname' => 'Admin',
            'username' => 'admin',
            'company' => 'Taskord',
            'bio' => 'Dabbing with Code',
            'email' => 'me@yogi.codes',
            'avatar' => 'https://secure.gravatar.com/avatar/1182dcc7c25fe6e84a11a5a983fa92ac?s=800',
            'password' => Hash::make('admin'),
            'website' => 'https://yogi.codes',
            'twitter' => 'evildabbit',
            'twitch' => 'evildabbit',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
