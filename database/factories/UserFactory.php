<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => str_replace('.', '', $this->faker->unique()->userName),
            'firstname' => $this->faker->firstName,
            'lastname' => $this->faker->lastName,
            'company' =>  $this->faker->firstName,
            'bio' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'avatar' => 'https://avatar.tobi.sh/'.$this->faker->userName.'.svg?text='.strtoupper($this->faker->randomLetter).strtoupper($this->faker->randomLetter),
            'reputation' => $this->faker->numberBetween($min = 50, $max = 150),
            'website' => 'https://example.com',
            'twitter' => str_replace('.', '', $this->faker->userName),
            'twitch' => str_replace('.', '', $this->faker->userName),
            'github' => str_replace('.', '', $this->faker->userName),
            'telegram' => str_replace('.', '', $this->faker->userName),
            'youtube' => str_replace('.', '', $this->faker->userName),
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => Hash::make('test'),
            'remember_token' => Str::random(10),
            'api_token' => Str::random(60),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'email_verified_at' => date('Y-m-d H:i:s'),
        ];
    }
}
