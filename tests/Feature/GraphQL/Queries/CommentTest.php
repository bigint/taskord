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

    public function test_all_comments_query()
    {
        $response = $this->graphQL('
        query {
          comment(first: 1) {
            edges {
              node {
                id
                comment
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
                                'comment' => 'Hello, World!',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
