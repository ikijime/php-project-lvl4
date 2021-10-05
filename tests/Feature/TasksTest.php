<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;

class TasksTest extends TestCase
{
    /** @test */
    use DatabaseMigrations;

    public function a_user_can_browse_tasks()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    /** @test */
    use DatabaseMigrations;

    public function an_unauthorized_user_cant_create_task()
    {
        $task = Task::factory()->make();

        $this->followingRedirects();

        $response = $this->post('/tasks', $task->toArray());
        $response->assertOk();
        $response->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function an_authorized_user_can_create_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->make();

        Auth::login($user);

        $this->followingRedirects();

        $response = $this->post('/tasks', $task->toArray());
        $response->assertOk();
        $response->assertSee('Task has been published');
    }
}
