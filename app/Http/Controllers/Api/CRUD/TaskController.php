<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Task\StoreRequest;
use App\Http\Resources\Api\Task\ItemResource;
use App\Http\Resources\Api\Task\ItemsResource;
use App\Models\Task;
use App\Repository\TaskRepository;
use Illuminate\Http\JsonResponse;

/**
 *
 */
class TaskController extends Controller
{


    /**
     * @param TaskRepository $taskRepository
     */
    public function __construct(private readonly TaskRepository $taskRepository)
    {

    }

    /**
     * @return mixed
     */
    public function index(): ItemsResource
    {
        $tasks = $this->taskRepository->get();

        return ItemsResource::make($tasks);
    }


    /**
     * @param StoreRequest $request
     * @return mixed
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $task = $this->taskRepository->store($validated);

        $resource = ItemResource::make($task);

        return response()->json([
            'message' => 'Task created successfully',
            'task' => $resource
        ], 201);
    }

    /**
     * @param Task $task
     * @return mixed
     */
    public function show(Task $task): ItemResource
    {
        return ItemResource::make($task);
    }


    /**
     * @param StoreRequest $request
     * @param Task $task
     * @return mixed
     */
    public function update(StoreRequest $request, Task $task): mixed
    {
        $validated = $request->validated();

        $task = $this->taskRepository->update($task, $validated);

        $resource = ItemResource::make($task);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $resource
        ], 201);
    }

    /**
     * @param Task $task
     * @return mixed
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->taskRepository->delete($task);

        return response()->json(['message' => 'Task deleted successfully'], 204);
    }
}
