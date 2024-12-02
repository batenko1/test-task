<?php

namespace Tests\Feature\Api;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use OpenApi\Annotations as OA;
use Tests\TestCase;


/**
 * @OA\Get(
 *     path="/api/tasks",
 *     summary="Получить список задач",
 *     description="Этот метод позволяет получить список всех задач",
 *     tags={"Task"},
 *     @OA\Response(
 *         response=200,
 *         description="Список задач из базы данных",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(
 *                 type="object",
 *                 @OA\Property(
 *                     property="id",
 *                     type="integer",
 *                 ),
 *                 @OA\Property(
 *                     property="title",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="author_id",
 *                 ),
 *                 @OA\Property(
 *                     property="reader_user_id",
 *                 ),
 *                 @OA\Property(
 *                     property="text",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="status",
 *                     type="string"
 *                 ),
 *                 @OA\Property(
 *                     property="deadline_date",
 *                     type="string",
 *                     format="date-time"
 *                 )
 *             )
 *         )
 *     ),
 *     security={{ "bearerAuth": {} }}
 * ),
 *
 * @OA\Get(
 *     path="/api/tasks/{task}",
 *     summary="Получить данные одной задачи",
 *     description="Этот метод позволяет получить данные задачи по идентификатору",
 *     tags={"Task"},
 *     @OA\Parameter(
 *       name="task",
 *       in="path",
 *       description="Идентификатор задачи",
 *       required=true,
 *       example="1",
 *       @OA\Schema(
 *         type="integer",
 *       ),
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Данные задачи по идентификатору",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(
 *                 property="id",
 *                 type="integer",
 *             ),
 *             @OA\Property(
 *                 property="title",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="author_id",
 *             ),
 *             @OA\Property(
 *                 property="reader_user_id",
 *             ),
 *             @OA\Property(
 *                 property="text",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="status",
 *                 type="string"
 *             ),
 *             @OA\Property(
 *                 property="deadline_date",
 *                 type="string",
 *                 format="date-time"
 *             )
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Задача с таким идентификатором не найдена"
 *     ),
 *     security={{ "bearerAuth": {} }}
 * ),
 *
 * @OA\Post(
 *     path="/api/tasks",
 *     summary="Создание новой задачи",
 *     description="Этот метод позволяет создать новую задачу",
 *     tags={"Task"},
 *     @OA\RequestBody(
 *         description="Данные для создания задачи",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="reader_user_id", type="integer"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="text", type="string"),
 *             @OA\Property(property="deadline_date", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Задача успешно создана",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", format="integer"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="reader_user_id", type="integer"),
 *             @OA\Property(property="text", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="deadline_date", type="string", format="date-time"),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка в данных для создания задачи"
 *     ),
 *     security={{ "bearerAuth": {} }}
 * ),
 *
 * @OA\Put(
 *     path="/api/tasks/{task}",
 *     summary="Обновление задачи",
 *     description="Этот метод позволяет обновить задачу по идентификатору",
 *     tags={"Task"},
 *     @OA\Parameter(
 *       name="task",
 *       in="path",
 *       description="Идентификатор задачи",
 *       required=true,
 *       example="1",
 *       @OA\Schema(
 *         type="integer",
 *       ),
 *     ),
 *     @OA\RequestBody(
 *         description="Данные для обновления задачи",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="reader_user_id", type="integer"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="text", type="string"),
 *             @OA\Property(property="deadline_date", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=201,
 *         description="Задача успешно обновлена",
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="id", type="integer", format="integer"),
 *             @OA\Property(property="title", type="string"),
 *             @OA\Property(property="author_id", type="integer"),
 *             @OA\Property(property="reader_user_id", type="integer"),
 *             @OA\Property(property="text", type="string"),
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="deadline_date", type="string", format="date-time"),
 *             @OA\Property(property="created_at", type="string", format="date-time"),
 *             @OA\Property(property="updated_at", type="string", format="date-time")
 *         )
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Задача с таким идентификатором не найдена"
 *     ),
 *     @OA\Response(
 *         response=422,
 *         description="Ошибка в данных для обновления задачи"
 *     ),
 *     security={{ "bearerAuth": {} }}
 * ),
 *
 * @OA\Delete(
 *     path="/api/tasks/{task}",
 *     summary="Удаление задачи",
 *     description="Этот метод позволяет удалить задачу по идентификатору",
 *     tags={"Task"},
 *     @OA\Parameter(
 *       name="task",
 *       in="path",
 *       description="Идентификатор задачи",
 *       required=true,
 *       example="1",
 *       @OA\Schema(
 *         type="integer"
 *       ),
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Задача успешно удалена"
 *     ),
 *     @OA\Response(
 *         response=404,
 *         description="Задача с таким идентификатором не найдена"
 *     ),
 *     security={{ "bearerAuth": {} }}
 * )
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;


    /**
     * Test the index method.
     *
     * @return void
     */
    public function test_index(): void
    {
        User::factory(30)->create();
        Task::factory()->count(5)->create();


        $bearerToken = config('app.api_bearer_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $bearerToken,
        ])
            ->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    /**
     * Test the store method.
     *
     * @return void
     */
    public function test_store(): void
    {
        User::factory(30)->create();
        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();


        $bearerToken = config('app.api_bearer_token');

        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()->format('Y-m-d H:i:s')
        ];

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->postJson('/api/tasks', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $data);
    }

    /**
     * Test the show method.
     *
     * @return void
     */
    public function test_show(): void
    {
        User::factory(30)->create();
        $task = Task::factory()->create();

        $bearerToken = config('app.api_bearer_token');

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->getJson('/api/tasks/' . $task->id);

        $response->assertStatus(200);

        $response->assertJsonFragment([
            'id' => $task->id,
            'title' => $task->title,
            'author_id' => $task->author_id,
            'reader_user_id' => $task->reader_user_id,
            'status' => $task->status,
            'text' => $task->text,
            'deadline_date' => Carbon::parse($task->deadline_date)->format('Y-m-d H:i:s'),
        ]);


    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_update(): void
    {
        User::factory(30)->create();
        $task = Task::factory()->create();

        $bearerToken = config('app.api_bearer_token');

        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();

        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()->format('Y-m-d H:i:s')
        ];

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->putJson('/api/tasks/' . $task->id, $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('tasks', $data);
    }


    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_bad_update_validation(): void
    {
        User::factory(30)->create();
        $task = Task::factory()->create();

        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();

        $data = [
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()
        ];

        $bearerToken = config('app.api_bearer_token');

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->putJson('/api/tasks/' . $task->id, $data);

        $response->assertStatus(422);
    }

    /**
     * Test the update method.
     *
     * @return void
     */
    public function test_bad_update(): void
    {
        $taskId = rand(10000, 100000);

        User::factory(30)->create();
        $author = User::query()->inRandomOrder()->first();
        $readerUser = User::query()->inRandomOrder()->first();

        $bearerToken = config('app.api_bearer_token');

        $data = [
            'title' => 'Test task',
            'author_id' => $author->id,
            'reader_user_id' => $readerUser->id,
            'status' => 'pending',
            'text' => 'text',
            'deadline_date' => now()->addYear()
        ];

        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->putJson('/api/tasks/' . $taskId, $data);

        $response->assertStatus(404);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_destroy(): void
    {

        User::factory(30)->create();
        $task = Task::factory()->create();

        $bearerToken = config('app.api_bearer_token');


        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->deleteJson('/api/tasks/' . $task->id);

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    /**
     * Test the destroy method.
     *
     * @return void
     */
    public function test_bad_destroy(): void
    {
        $bearerToken = config('app.api_bearer_token');

        $taskId = rand(10000, 100000);
        $response = $this
            ->withHeaders([
                'Authorization' => 'Bearer ' . $bearerToken,
            ])
            ->deleteJson('/api/tasks/' . $taskId);

        $response->assertStatus(404);
    }
}
