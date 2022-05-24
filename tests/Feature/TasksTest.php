<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    private mixed $task;
    private mixed $status1;
    private mixed $status2;
    private mixed $user1;
    private mixed $user2;

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
        $this->get(route('tasks.index'))
            ->assertStatus(200);
    }

    /** @test */
    public function anUnauthorizedUserCantCreateTask()
    {
        $this->followingRedirects()
            ->post(route('tasks.index'), $this->task->toArray())
            ->assertOk()
            ->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function anAuthorizedUserCanCreateTask()
    {
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->post('/tasks', $this->task->toArray())
            ->assertOk()
            ->assertSee($this->task->name)
            ->assertSee('Задача успешно создана');

        $this->actingAs($this->user1)
            ->followingRedirects()
            ->post('/tasks', $this->task->toArray())
            ->assertOk()
            ->assertSee($this->task->name)
            ->assertSee('с таким именем уже существует');
    }

    /** @test */
    public function aUserCanBrowseSingleTask()
    {
        $task = Task::factory()->create();
        $this->get(route('tasks.index', $task->id))
            ->assertOk()
            ->assertSee($task['name']);
    }

    /** @test */
    public function aUserCanFilterByAuthor()
    {
        $this->get('/tasks?filter[status_id]=&filter[created_by_id]=+' . $this->user1->id . '+&filter[assigned_to_id]=')
            ->assertSee('<td>FirstUser</td>', false)
            ->assertDontSee('<td>SecondUser</td>', false);
    }


    /** @test */
    public function aUserCanFilterByExecutorAndStatus()
    {
        Task::factory(2)->create(['assigned_to_id' => $this->user1->id, 'status_id' =>  $this->status1->id]);
        Task::factory(2)->create(['assigned_to_id' => $this->user2->id, 'status_id' => $this->status2->id]);

        $this->get('/tasks?filter[status_id]=&filter[created_by_id]=&filter[assigned_to_id]=+' . $this->user1->id . '+')
        ->assertSee("<td>{$this->status1->name}</td>", false)
        ->assertSee('<td>FirstUser</td>', false)
        ->assertDontSee("<td>{$this->status2->name}</td>", false)
        ->assertDontSee('<td>SecondUser</td>', false);
    }
}
