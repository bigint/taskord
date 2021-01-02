<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Task::factory()->create([
            'user_id' => 1,
            'product_id' => 1,
            'task' => 'Hello, World!',
            'done' => true,
        ]);

        Task::factory()->count(499)->create();
    }
}
