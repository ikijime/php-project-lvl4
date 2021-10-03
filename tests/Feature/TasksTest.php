<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

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
    public function a_authorized_user_can_create_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create();

        $this->followingRedirects();

        $response = $this->actingAs($user)->post('/tasks', $task->toArray());
        $response->assertSee($task->name);

    }
}
