<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
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
        User::factory()->create([
            'firstname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'password' => Hash::make('admin'),
            'isStaff' => true,
        ]);

        User::factory()->create([
            'firstname' => 'Test',
            'username' => 'test',
        ]);
    }
}
