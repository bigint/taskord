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

    public function test_all_answers_query()
    {
        $response = $this->graphQL('
        query {
          answers(first: 1) {
            edges {
              node {
                id
                answer
              }
            }
          }
        }
        ')
        ->assertJson([
            'data' => [
                'answers' => [
                    'edges' => [
                        [
                            'node' => [
                                'id' => '1',
                                'answer' => 'Hello, World!',
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
