<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskStatusTest extends TestCase
{
    use DatabaseMigrations;

    private mixed $user1;
    private mixed $status1;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);
        $this->actingAs($this->user1);
    }

    /** @test */
    public function createTaskStatus(): void
    {
        $this->get(route('task_statuses.create'))
            ->assertOk();
    }

    /** @test */
    public function showTaskStatus(): void
    {
        $this->get(route('task_statuses.show', $this->status1->id))
            ->assertRedirect();
    }

    /** @test */
    public function editTaskStatus(): void
    {
        $this->get(route('task_statuses.edit', $this->status1->id))
            ->assertOk()
            ->assertSee($this->status1->name);
    }

    /** @test */
    public function deleteTaskStatus(): void
    {
        $this->delete(route('task_statuses.destroy', $this->status1->id));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'FirstStatus']);
    }
}
