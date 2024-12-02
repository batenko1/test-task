<?php

namespace Tests\Unit;

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
use Illuminate\Support\Facades\Validator;
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
        User::factory(30)->create();

        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();

        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()
        ];

        $task = Mockery::mock(Task::class)->makePartial();

        $task->shouldReceive('jsonSerialize')->andReturn($data);
        $task->shouldReceive('getAttribute')->andReturnUsing(function ($attribute) use ($data) {
            return $data[$attribute] ?? null;
        });
        $task->shouldReceive('toArray')->andReturn($data);

        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('update')->once()->with($task, $data)->andReturn($task);

        $request = StoreRequest::create('/api/tasks/' . $task->id, 'PUT', $data);
        $request->setJson(new \Illuminate\Http\Request($data));
        $request->setLaravelSession(app('session')->driver());
        $request->setValidator(Validator::make($data, (new StoreRequest)->rules()));

        $controller = new TaskController($taskRepository);

        $response = $controller->update($request, $task);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $this->assertEquals([
            'message' => 'Task updated successfully',
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'author_id' => $task->author_id,
                'reader_user_id' => $task->reader_user_id,
                'status' => $task->status,
                'text' => $task->text,
                'deadline_date' => Carbon::parse($task->deadline_date)->format('Y-m-d H:i:s'),
            ]
        ], $response->getData(true));
    }






    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy(): void
    {

        $task = new Task(['title' => 'Test task']);

        $taskRepository = Mockery::mock(TaskRepository::class);
        $taskRepository->shouldReceive('delete')->once()->with($task);

        $controller = new TaskController($taskRepository);

        $response = $controller->destroy($task);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
        $this->assertEquals([
            'message' => 'Task deleted successfully'
        ], $response->getData(true));
    }
}
