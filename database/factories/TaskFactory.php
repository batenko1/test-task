<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
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
        $user = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();
        return [
            'author_id' => $user->id,
            'reader_user_id' => $readerUser->id,
            'title' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'text' => $this->faker->paragraph,
            'created_at' => $this->faker->dateTimeThisYear,
            'deadline_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'updated_at' => $this->faker->dateTimeThisYear,
        ];
    }
}
