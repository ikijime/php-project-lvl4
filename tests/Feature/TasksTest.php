<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->make();

        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);
        $this->status2 = TaskStatus::factory()->create(['name' => 'SecondStatus']);

        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);

        Task::factory(2)->create(['created_by_id' => $this->user1->id]);
        Task::factory(2)->create(['created_by_id' => $this->user2->id]);
    }

    /** @test */
    public function aUserCanBrowseTasks()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    /** @test */
    public function anUnauthorizedUserCantCreateTask()
    {
        $this->followingRedirects();

        $response = $this->post('/tasks', $this->task->toArray());
        $response->assertOk();
        $response->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function anAuthorizedUserCanCreateTask()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $this->followingRedirects();
        $response = $this->post('/tasks', $this->task->toArray());
        $response->assertOk();
        $response->assertSee($this->task->name);
        $response->assertSee('Задача успешно создана');

        $this->followingRedirects();
        $response = $this->post('/tasks', $this->task->toArray());
        $response->assertOk();
        $response->assertSee($this->task->name);
        $response->assertSee(' с таким именем уже существует');
    }

    /** @test */
    public function aUserCanBrowseSingleTask()
    {
        $task = Task::factory()->create();
        $response = $this->get("/tasks/{$task->id}");
        $response->assertOk();
        $response->assertSee($task->name);
    }

    /** @test */
    public function aUserCanFilterByAuthor()
    {
        $response = $this->get('/tasks?filter[status_id]=&filter[created_by_id]=+' . $this->user1->id . '+&filter[assigned_to_id]=');
        $response->assertSee('<td>FirstUser</td>', $escaped = false);
        $response->assertDontSee('<td>SecondUser</td>', $escaped = false);
    }


    /** @test */
    public function aUserCanFilterByExecutorAndStatus()
    {
        Task::factory(2)->create(['assigned_to_id' => $this->user1->id, 'status_id' =>  $this->status1->id]);
        Task::factory(2)->create(['assigned_to_id' => $this->user2->id, 'status_id' => $this->status2->id]);

        $response = $this->get('/tasks?filter[status_id]=&filter[created_by_id]=&filter[assigned_to_id]=+' . $this->user1->id . '+');

        $response->assertSee("<td>{$this->status1->name}</td>", false);
        $response->assertSee('<td>FirstUser</td>', false);
        $response->assertDontSee("<td>{$this->status2->name}</td>", false);
        $response->assertDontSee('<td>SecondUser</td>', false);
    }
}
