<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_single_comment_query()
    {
        $response = $this->graphQL('
        query {
          comment(id: 1) {
            id
            comment
          }
        }
        ')
        ->assertJson([
            'data' => [
                'task' => [
                    'id' => '1',
                    'comment' => 'Hello, World!',
                ],
            ],
        ]);
    }

    public function test_all_tasks_query()
    {
        $response = $this->graphQL('
        query {
          tasks(first: 1) {
            edges {
              node {
                id
                task
                image
                done
                type
                source
                hidden
              }
            }
          }
        }
        ')
        ->assertJson([
            'data' => [
                'tasks' => [
                    'edges' => [
                        [
                            'node' => [
                                'id' => '1',
                                'task' => 'Hello, World!',
                                'image' => null,
                                'done' => true,
                                'type' => 'user',
                                'source' => 'Taskord for Web',
                                'hidden' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
