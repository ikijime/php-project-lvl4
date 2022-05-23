<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskStatusTest extends TestCase
{
    use DatabaseMigrations;

    private $user1;
    private $user2;
    private $status1;
    private $status2;
    private $task1;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);

        Auth::login($this->user1);
        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);
        $this->status2 = TaskStatus::factory()->create(['name' => 'SecondStatus']);

        $this->task1 = Task::factory()->create(['status_id' => $this->status2->id]);
    }

    /** @test */
    public function createTaskStatus(): void
    {
        $response = $this->get('/task_statuses/create');
        $response->assertOk();
    }

    /** @test */
    public function showTaskStatus(): void
    {
        $response = $this->get("/task_statuses/{$this->status1->id}");
        $response->assertRedirect();
    }

    /** @test */
    public function editTaskStatus(): void
    {
        $response = $this->get("/task_statuses/{$this->status1->id}/edit");
        $response->assertOk();
        $response->assertSee($this->status1->name);
    }

    /** @test */
    public function deleteTaskStatus(): void
    {
        $this->delete("/task_statuses/{$this->status1->id}");
        $this->assertDatabaseMissing('task_statuses', ['name' => 'FirstStatus']);
    }
}
