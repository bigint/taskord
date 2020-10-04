<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class QuestionTest extends TestCase
{
    public function test_single_question_query()
    {
        $response = $this->graphQL('
        query {
          question(id: 1) {
            id
            title
            body
            patronOnly
          }
        }
        ')
        ->assertJson([
            'data' => [
                'question' => [
                    'id' => '1',
                    'title' => 'Hello, World!',
                    'body' => 'Hello, World!',
                    'patronOnly' => false,
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
