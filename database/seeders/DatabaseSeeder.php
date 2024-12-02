<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(30)->create();
        Task::factory(200)->create();

    }
}
