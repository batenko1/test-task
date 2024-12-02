<?php

namespace App\Repository;

use App\Models\Task;
use Illuminate\Support\Collection;

/**
 *
 */
class TaskRepository
{



    /**
     * @param Task $task
     *
     * Initialization model Task
     */
    public function __construct(private readonly Task $task)
    {}

    /**
     * @return Collection
     *
     * Get list tasks
     */
    public function get(): Collection
    {
        return $this->task
            ->query()
            ->get();
    }


    /**
     * @param $data
     * @return Task
     *
     * Create task by DATA
     */
    public function store($data): Task
    {
        return $this->task
            ->query()
            ->create($data);
    }

    /**
     * @param $task
     * @param $data
     * @return Task
     *
     * Update task by DATA
     */
    public function update($task, $data): Task
    {
        $task->update($data);

        return $task;
    }

    /**
     * @param $task
     * @return void
     *
     * Delete task
     */
    public function delete($task): void
    {
        $task->delete();
    }


}
