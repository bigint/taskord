<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TaskSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductUpdateSeeder::class);
        $this->call(QuestionSeeder::class);
        $this->call(AnswerSeeder::class);
        $this->call(MilestoneSeeder::class);
        $this->call(MeetupSeeder::class);
        $this->call(FeatureSeeder::class);
        $this->call(ProfileBadgeSeeder::class);
    }
}
