<?php

namespace App\Repository;

use App\Models\Task;
use Illuminate\Support\Collection;

class TaskRepository
{


    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function get(): Collection
    {
        return $this->task
            ->query()
            ->get();
    }


    public function store($data): Task
    {
        return $this->task
            ->query()
            ->create($data);
    }

    public function update($task, $data): Task
    {
        $task->update($data);

        return $task;
    }

    public function delete($task): void
    {
        $task->delete();
    }


}
