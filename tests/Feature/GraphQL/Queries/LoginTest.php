<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_valid_login()
    {
        $response = $this->graphQL('
        mutation {
          login(email: "taskord+test@icloud.com", password: "admin") {
            token
            response
          }
        }
        ')
        ->assertJson([
            'data' => [
                'login' => [
                    'token' => 'Ajfow3xVyqqHD3lRFirc6bRD8xzPov65XdXDbevR6ytxKS3pXoINUgIVRNpc',
                    'response' => 'Success',
                ],
            ],
        ]);
    }

    public function test_invalid_login()
    {
        $response = $this->graphQL('
        mutation {
          login(email: "taskord+test@icloud.co", password: "admin") {
            token
            response
          }
        }
        ')
        ->assertJson([
            'data' => [
                'login' => [
                    'token' => null,
                    'response' => 'Invalid Credentials',
                ],
            ],
        ]);
    }

    public function test_suspended_login()
    {
        $response = $this->graphQL('
        mutation {
          login(email: "suspended@taskord.com", password: "test") {
            token
            response
          }
        }
        ')
        ->assertJson([
            'data' => [
                'login' => [
                    'token' => null,
                    'response' => 'Your account is suspended!',
                ],
            ],
        ]);
    }
}
