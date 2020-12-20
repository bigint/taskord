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

    // public function test_all_tasks_query()
    // {
    //     $response = $this->graphQL('
    //     query {
    //       tasks(first: 1, done: false) {
    //         edges {
    //           node {
    //             id
    //             task
    //             image
    //             done
    //             type
    //             source
    //             hidden
    //           }
    //         }
    //       }
    //     }
    //     ')
    //     ->assertJson([
    //         'data' => [
    //             'tasks' => [
    //                 'edges' => [
    //                     [
    //                         'node' => [
    //                             'id' => '1',
    //                             'task' => 'Hello, World!',
    //                             'image' => null,
    //                             'done' => true,
    //                             'type' => 'user',
    //                             'source' => 'Taskord for Web',
    //                             'hidden' => false,
    //                         ],
    //                     ],
    //                 ],
    //             ],
    //         ],
    //     ]);
    // }
}
