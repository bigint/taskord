<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class TaskTest extends TestCase
{
    public function test_single_task_query()
    {
        $response = $this->graphQL('
        query {
          task(id: 1) {
            id
            task
            image
            done
            type
            source
            hidden
          }
        }
        ')
        ->assertJson([
            'data' => [
                'task' => [
                    'id' => '1',
                    'task' => 'Hello, World!',
                    'image' => null,
                    'done' => true,
                    'type' => 'user',
                    'source' => 'Taskord for Web',
                    'hidden' => false,
                ],
            ],
        ]);
    }

    
}
