<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        // Public Question
        Question::factory()->create([
            'user_id' => 1,
            'title' => 'Hello, World this is public question!',
            'body' => 'Hello, World!',
            'patronOnly' => false,
        ]);

        // Patron Only Question
        Question::factory()->create([
            'user_id' => 1,
            'title' => 'Hello, World this is patron only question!',
            'body' => 'Hello, World!',
            'patronOnly' => true,
        ]);

        Question::factory()->count(98)->create();
    }
}
