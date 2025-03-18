<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Psy\Util\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(), // Use fake()->sentence() for a random title
            'description' => fake()->paragraph(), // Generate a random paragraph as description
            'status' => 'not done', // Fixed value for status
            'deadline' => fake()->date(), // Random date for deadline
            'user_id' => User::inRandomOrder()->first()->id, // Fetch a random user's id
            'project_id' => Project::inRandomOrder()->first()->id,
        ];
    }

}
