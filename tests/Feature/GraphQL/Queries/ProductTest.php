<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_single_product_query()
    {
        $response = $this->graphQL('
        query {
          product(id: 1) {
            id
            slug
            name
            avatar
            description
            website
            twitter
            repo
            producthunt
            launched
          }
        }
        ')
        ->assertJson([
            'data' => [
                'product' => [
                    'id' => '1',
                    'slug' => 'taskord',
                    'name' => 'Taskord',
                    'avatar' => 'https://i.imgur.com/QpfHEy6.png',
                    'description' => 'Get things done socially with Taskord',
                    'website' => 'https://taskord.com',
                    'twitter' => 'taskord',
                    'repo' => 'https://gitlab.com/taskord/taskord',
                    'producthunt' => 'taskord',
                    'launched' => true,
                ],
            ],
        ]);
    }

    public function test_all_products_query()
    {
        $response = $this->graphQL('
        query {
          products(first: 1) {
            edges {
              node {
                id
                slug
                name
                avatar
                description
                website
                twitter
                repo
                producthunt
                launched
              }
            }
          }
        }
        ')
        ->assertJson([
            'data' => [
                'products' => [
                    'edges' => [
                        [
                            'node' => [
                                'id' => '1',
                                'slug' => 'taskord',
                                'name' => 'Taskord',
                                'avatar' => 'https://i.imgur.com/QpfHEy6.png',
                                'description' => 'Get things done socially with Taskord',
                                'website' => 'https://taskord.com',
                                'twitter' => 'taskord',
                                'repo' => 'https://gitlab.com/taskord/taskord',
                                'producthunt' => 'taskord',
                                'launched' => true,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
