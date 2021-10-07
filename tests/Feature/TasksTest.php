<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->task = Task::factory()->make();
    }

    /** @test */
    public function a_user_can_browse_tasks()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    /** @test */
    public function an_unauthorized_user_cant_create_task()
    {

        $this->followingRedirects();

        $response = $this->post('/tasks', $this->task->toArray());
        $response->assertOk();
        $response->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function an_authorized_user_can_create_task()
    {
        $user = User::factory()->create();

        Auth::login($user);

        $this->followingRedirects();
        $response = $this->post('/tasks', $this->task->toArray());
        $response->assertOk();
        $response->assertSee($this->task->name);
        $response->assertSee('Task has been published');
    }

    /** @test */
    public function a_user_can_browse_single_task()
    {
        $task = Task::factory()->create();
        $response = $this->get("/tasks/{$task->id}");
        $response->assertOk();
        $response->assertSee($task->name);
    }
}
