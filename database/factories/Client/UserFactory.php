<?php

namespace Database\Factories\Client;

use App\Models\Client\User;
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
            'id' => Str::orderedUuid()->toString(),
            'city_id' => 1,
            'username' => $this->faker->userName(),
            'first_name' => $firstName = $this->faker->firstName(),
            'last_name' => $lastName = $this->faker->lastName(),
            'name' => $firstName . $lastName,
            'img' => '',
            'email' => $this->faker->unique()->safeEmail(),
            'birthday' => $this->faker->dateTimeBetween('-30 years', '-20 years'),
            'user_scope' => 'user',
            'email_verified_at' => now(),
            'password' => 'password',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_scope' => 'admin'
            ];
        });
    }

    public function user()
    {
        return $this->state(function (array $attributes) {
            return [
                'user_scope' => 'user'
            ];
        });
    }
}
