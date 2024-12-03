<?php

namespace tests\Unit\Api\CRUD;

use App\Http\Controllers\Api\CRUD\TaskController;
use App\Http\Requests\Api\Task\StoreRequest;
use App\Http\Resources\Api\Task\ItemResource;
use App\Http\Resources\Api\Task\ItemsResource;
use App\Models\Task;
use App\Models\User;
use App\Repository\TaskRepository;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Mockery;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index(): void
    {
        $tasks = new Collection([new Task(['title' => 'Test task'])]);

        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('get')->once()->andReturn($tasks);

        $controller = new TaskController($taskRepository);

        $response = $controller->index();

        $this->assertInstanceOf(ItemsResource::class, $response);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store(): void
    {
        $author = User::factory()->create();
        $readerUser = User::factory()->create();

        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()
        ];

        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('store')
            ->once()
            ->with($data)
            ->andReturn(new Task($data));

        $controller = new TaskController($taskRepository);

        $request = Mockery::mock(StoreRequest::class);
        $request->shouldReceive('validated')->andReturn($data);

        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $responseData = $response->getData(true);

        $this->assertEquals('Task created successfully', $responseData['message']);
        $this->assertEquals($data['title'], $responseData['task']['title']);
        $this->assertEquals($data['author_id'], $responseData['task']['author_id']);
        $this->assertEquals($data['reader_user_id'], $responseData['task']['reader_user_id']);
        $this->assertEquals($data['status'], $responseData['task']['status']);
        $this->assertEquals($data['text'], $responseData['task']['text']);
        $this->assertEquals(Carbon::parse($data['deadline_date'])->format('Y-m-d H:i:s'), $responseData['task']['deadline_date']);
    }



    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_show(): void
    {
        $task = new Task(['title' => 'Test task']);

        $controller = new TaskController(new TaskRepository($task));
        $response = $controller->show($task);

        $this->assertInstanceOf(ItemResource::class, $response);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update(): void
    {
        // Создаём 30 пользователей
        User::factory(30)->create();

        // Выбираем автора и читателя случайным образом
        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();

        // Создаём задачу
        $task = Task::factory()->create();

        // Данные для обновления задачи
        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()->toDateTimeString(),
        ];

        // Создаём объект задачи с обновлёнными данными
        $updatedTask = new Task(array_merge($task->toArray(), $data));

        // Мокаем TaskRepository
        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('update')
            ->once()
            ->with($task->id, $data)
            ->andReturn($updatedTask);

        // Создаём запрос с валидированными данными
        $request = Mockery::mock(StoreRequest::class)->makePartial();
        $request->shouldReceive('validated')->andReturn($data);

        // Создаём контроллер с моком репозитория
        $controller = new TaskController($taskRepository);

        // Выполняем действие
        $response = $controller->update($request, $task);

        // Проверяем результат
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $expectedResponse = [
            'message' => 'Task updated successfully',
            'task' => [
                'id' => $updatedTask->id,
                'title' => $updatedTask->title,
                'author_id' => $updatedTask->author_id,
                'reader_user_id' => $updatedTask->reader_user_id,
                'status' => $updatedTask->status,
                'text' => $updatedTask->text,
                'deadline_date' => $updatedTask->deadline_date,
                'created_at' => $updatedTask->created_at,
                'updated_at' => $updatedTask->updated_at,
            ],
        ];

        $this->assertEquals($expectedResponse, $response->getData(true));
    }









    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy(): void
    {

        User::factory(30)->create();
        Task::factory(3)->create();
        $task = Task::query()->inRandomOrder()->first();

        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('delete')->once()->with($task->id);

        $controller = new TaskController($taskRepository);

        $response = $controller->destroy($task);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Task deleted successfully'
        ], $response->getData(true));
    }
}
