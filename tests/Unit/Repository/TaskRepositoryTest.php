<?php

namespace Tests\Unit\Repository;

use App\Models\Task;
use App\Repository\TaskRepository;
use Illuminate\Database\Eloquent\Builder;
use Mockery;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;


class TaskRepositoryTest extends TestCase
{
    /**
     * @var TaskRepository
     */
    protected TaskRepository $repository;
    /**
     * @var Task|(MockInterface&Task&Mockery\LegacyMockInterface)|MockInterface|(MockInterface&Mockery\LegacyMockInterface)
     */
    protected Task|MockInterface $taskMock;

    /**
     * @return void
     *
     * Prepare for test
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->taskMock = Mockery::mock(Task::class);
        $this->repository = new TaskRepository($this->taskMock);
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    /**
     * @return void
     *
     * Test get list tasks
     */
    public function test_get_returns_collection(): void
    {
        $tasks = collect(['task1', 'task2']);
        $this->taskMock
            ->shouldReceive('query->get')
            ->once()
            ->andReturn($tasks);

        $result = $this->repository->get();

        $this->assertSame($tasks, $result);
    }

    /**
     * @return void
     *
     * Test find task by id
     */
    public function test_find_returns_task_by_id(): void
    {
        $task = new Task(['id' => 1, 'title' => 'Test Task']);

        $queryMock = Mockery::mock(Builder::class);


        $this->taskMock
            ->shouldReceive('query')
            ->once()
            ->andReturn($queryMock);


        $queryMock
            ->shouldReceive('id')
            ->with(1)
            ->once()
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($task);

        $result = $this->repository->find(1);

        $this->assertEquals($task, $result);
    }


    /**
     * @return void
     *
     * Test create Task
     */
    public function test_store_creates_task(): void
    {
        $data = ['title' => 'New Task'];
        $task = new Task($data);

        $this->taskMock
            ->shouldReceive('query->create')
            ->with($data)
            ->once()
            ->andReturn($task);

        $result = $this->repository->store($data);

        $this->assertEquals($task, $result);
    }

    /**
     * @return void
     *
     * Test update task
     */
    public function test_update_updates_task(): void
    {
        $data = ['title' => 'Updated Task'];


        $task = Mockery::mock(Task::class);
        $task->shouldReceive('update')
        ->with($data)
        ->once()
            ->andReturn(true);


        $queryMock = Mockery::mock(Builder::class);


        $this->taskMock
            ->shouldReceive('query')
            ->once()
            ->andReturn($queryMock);


        $queryMock
            ->shouldReceive('id')
            ->with(1)
            ->once()
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($task);

        $result = $this->repository->update(1, $data);

        $this->assertSame($task, $result);
    }


    /**
     * @return void
     *
     * Test remove task
     */
    public function test_delete_removes_task(): void
    {
        $task = Mockery::mock(Task::class);


        $task->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $queryMock = Mockery::mock(Builder::class);

        $this->taskMock
            ->shouldReceive('query')
            ->once()
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('id')
            ->with(1)
            ->once()
            ->andReturn($queryMock);

        $queryMock
            ->shouldReceive('first')
            ->once()
            ->andReturn($task);

        $result = $this->repository->delete(1);

        $this->assertTrue($result);
    }

}
