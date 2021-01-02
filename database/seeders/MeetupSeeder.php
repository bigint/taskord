<?php

namespace Database\Seeders;

use App\Models\Meetup;
use Illuminate\Database\Seeder;

class MeetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meetup::factory()->count(30)->create();
    }
}
