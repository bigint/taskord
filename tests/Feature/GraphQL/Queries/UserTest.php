<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class UserTest extends TestCase
{
    public function test_user_query()
    {
        $response = $this->graphQL('
        query {
          user(id: 1) {
            id
            username
            firstname
            lastname
            avatar
            bio
            location
            company
            website
            twitter
            twitch
            telegram
            github
            youtube
            isStaff
            isVerified
            isDeveloper
            isBeta
            isPatron
            isPrivate
            isSuspended
          }
        }
        ')
        ->assertJson([
            'data' => [
                'user' => [
                    'id' => '1',
                    'username' => 'test',
                    'firstname' => 'Firstname',
                    'lastname' => 'Lastname',
                    'avatar' => 'https://contractize.com/wp-content/uploads/2017/02/Robot.jpg',
                    'bio' => 'Test the taskord',
                    'location' => 'Internet',
                    'company' => 'Taskord',
                    'website' => 'https://taskord.test',
                    'twitter' => 'test',
                    'twitch' => 'test',
                    'telegram' => 'test',
                    'github' => 'test',
                    'youtube' => 'test',
                    'isStaff' => true,
                    'isVerified' => false,
                    'isDeveloper' => true,
                    'isBeta' => true,
                    'isPatron' => true,
                    'isPrivate' => false,
                    'isSuspended' => false,
                ],
            ],
        ]);
    }
}
