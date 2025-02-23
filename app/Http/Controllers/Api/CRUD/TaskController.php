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
 * Controller for work with tasks
 */
class TaskController extends Controller
{


    /**
     * @param TaskRepository $taskRepository
     *
     * Initialization TaskRepository for work with Tasks
     */
    public function __construct(private readonly TaskRepository $taskRepository)
    {

    }

    /**
     * @return ItemsResource
     *
     * Return formatted list Tasks
     *
     */
    public function index(): ItemsResource
    {
        $tasks = $this->taskRepository->get();

        return ItemsResource::make($tasks);
    }


    /**
     * @param StoreRequest $request
     * @return JsonResponse
     *
     * Create task and return her with status
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
     * @return ItemResource
     *
     *
     * Show task by ID
     */
    public function show(Task $task): ItemResource
    {
        return ItemResource::make($task);
    }


    /**
     * @param StoreRequest $request
     * @param Task $task
     * @return JsonResponse
     *
     *
     * Update task and return task with message
     */
    public function update(StoreRequest $request, Task $task): JsonResponse
    {
        $validated = $request->validated();

        $task = $this->taskRepository->update($task->id, $validated);

        $resource = ItemResource::make($task);

        return response()->json([
            'message' => 'Task updated successfully',
            'task' => $resource
        ], 201);
    }

    /**
     * @param Task $task
     * @return JsonResponse
     *
     * Delete task from DB and return message
     */
    public function destroy(Task $task): JsonResponse
    {
        $this->taskRepository->delete($task->id);

        return response()->json([
            'message' => 'Task deleted successfully'
        ], 204);
    }
}
