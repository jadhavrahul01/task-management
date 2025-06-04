<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            // 'user_id' => $this->faker->numberBetween(2, 5), // update as per your user IDs
            'user_id' => 2,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'expires_at' => $this->faker->dateTimeBetween('now', '+10 days'),
            'completed_at' => null,
        ];
    }
}
