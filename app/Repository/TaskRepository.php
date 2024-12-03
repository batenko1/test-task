<?php

namespace App\Repository;

use App\Models\Task;
use App\Repository\Contract\RepositoryInterface;
use Illuminate\Support\Collection;

/**
 * Repository for work with tasks
 */
class TaskRepository implements RepositoryInterface
{


    /**
     * @param Task $task
     *
     * Initialization model Task
     */
    public function __construct(private readonly Task $task)
    {
    }

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
     * @param int $id
     * @return Task
     */
    public function find(int $id): Task
    {
        return $this->task
            ->query()
            ->id($id)
            ->first();
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
     * @param int $id
     * @param array $data
     * @return Task Update task by DATA
     *
     * Update task by DATA
     */
    public function update(int $id, array $data): Task
    {
        $task = $this->find($id);

        $task->update($data);

        return $task;
    }

    /**
     * @param $task
     * @return void
     *
     * Delete task
     */
    public function delete(int $id): bool
    {
        $task = $this->find($id);

        $task->delete();

        return true;
    }


}
