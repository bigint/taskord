<?php

namespace Database\Seeders;

use App\Models\ProfileBadge;
use Illuminate\Database\Seeder;

class ProfileBadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProfileBadge::factory()->count(100)->create();
    }
}
