<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProdAdminSeeder extends Seeder
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
            'email' => 'me@yogi.codes',
            'avatar' => 'https://secure.gravatar.com/avatar/1182dcc7c25fe6e84a11a5a983fa92ac?s=800',
            'password' => Hash::make('admin'),
            'website' => 'https://yogi.codes',
            'twitter' => 'evildabbit',
            'onlyFollowingsTasks' => false,
            'isStaff' => true,
            'isDeveloper' => true,
            'isBeta' => true,
            'isPatron' => true,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
