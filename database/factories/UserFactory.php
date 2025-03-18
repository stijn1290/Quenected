<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'team_id' => fake()->numberBetween(1, 2),
            'remember_token' => Str::random(10),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            $role = Role::inRandomOrder()->first();
            if ($role) {
                $user->assignRole($role->name);
            }
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
}
