<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskTest extends TestCase
{
    use DatabaseMigrations;
    private Task $task1;
    private $tasks;
    private User $user1;
    private User $user2;
    private TaskStatus $status1;
    
    public function setUp(): void
    {
        parent::setUp();

        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);
        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);
        Auth::login($this->user1);
        $this->task1 = Task::factory()->create(['author_id' => $this->user1->id]);
    }

    /** @test */
    public function create_task(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertOk();
        $response->assertSee('Создать');
    }


    /** @test */
    public function edit_task(): void
    {
        $taskid = $this->task1->id;
        $response = $this->get("/tasks/{$taskid}/edit");
        $response->assertOk();

        Auth::login($this->user2);

        $response = $this->get("/tasks/{$taskid}/edit");
        $response->assertRedirect();
    }

    /** @test */
    public function update_task(): void
    {
        $this->followingRedirects();
        $newData = ['name' => 'New name', 'description' => 'New description'];
        $response = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response->assertSee("The status id field is required.");

        $this->followingRedirects();
        $newData['status_id'] = $this->status1->id;
        $newData['assigned_to_id'] = $this->user2->id;
        $response2 = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response2->assertSee('Updated successfully');

        $newData['labels'] = [1,2];
        $response3 = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response3->assertSee('Updated successfully');
    }

    /** @test */
    public function delete_task(): void
    {
        $this->followingRedirects();
        $taskid = $this->task1->id;
        $response = $this->delete("/tasks/{$taskid}");
        $response->assertSee("Task {$this->task1->name} has been deleted");
    }
}
