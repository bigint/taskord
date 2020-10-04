<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class AnswerTest extends TestCase
{
    public function test_single_answer_query()
    {
        $response = $this->graphQL('
        query {
          answer(id: 1) {
            id
            answer
          }
        }
        ')
        ->assertJson([
            'data' => [
                'answer' => [
                    'id' => '1',
                    'answer' => 'Hello, World!',
                ],
            ],
        ]);
    }

    public function test_all_comments_query()
    {
        $response = $this->graphQL('
        query {
          comments(first: 1) {
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
                'comments' => [
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
