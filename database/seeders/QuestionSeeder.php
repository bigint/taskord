<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        Question::factory()->create([
            'user_id' => 1,
            'title' => 'Hello, World!',
            'body' => 'Hello, World!',
            'patronOnly' => false,
        ]);

        Question::factory()->count(99)->create();
    }
}
