<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'title' => 'Task 1',
                'description' => 'Description for task 1',
                'status' => 'pending',
                'user_id' => 2,
                'priority' => 'high',
                'expires_at' => now()->addDays(2)
            ],
            [
                'title' => 'Task 2',
                'description' => 'Description for task 2',
                'status' => 'completed',
                'user_id' => 3,
                'priority' => 'medium',
                'expires_at' => now()->addDays(2)
            ],
            [
                'title' => 'Task 3',
                'description' => 'Description for task 3',
                'status' => 'in_progress',
                'user_id' => 2,
                'priority' => 'low',
                'expires_at' => now()->addDays(2)
            ],
            [
                'title' => 'Task 4',
                'description' => 'Description for task 4',
                'status' => 'completed',
                'user_id' => 4,
                'priority' => 'high',
                'completed_at' => now()->addDay(),
                'expires_at' => now()->addDays(2)
            ],
            [
                'title' => 'Task 5',
                'description' => 'Description for task 5',
                'status' => 'pending',
                'user_id' => 4,
                'priority' => 'medium',
                'expires_at' => now()->addDays(2)
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
        Task::factory()->count(10)->create();
    }
}
