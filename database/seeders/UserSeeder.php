<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'password' => Hash::make('admin'),
            'isPatron' => true,
            'isStaff' => true,
        ]);

        // 2
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Test',
            'username' => 'test',
        ]);

        // 3
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Suspended',
            'username' => 'suspended',
            'isSuspended' => true,
            'isFlagged' => true,
            'email' => 'suspended@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
        ]);

        // 4
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Unverified',
            'username' => 'unverified',
            'email' => 'unverified@taskord.com',
            'avatar' => 'https://i.imgur.com/QpfHEy6.png',
            'email_verified_at' => null,
        ]);

        // 5
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Ops',
            'username' => 'ops',
        ]);

        // 6
        User::factory()->create([
            'firstname' => 'Taskord',
            'lastname' => 'Ghost',
            'username' => 'ghost',
        ]);

        User::factory()->count(44)->create();
    }
}
