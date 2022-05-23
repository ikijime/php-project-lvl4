<?php

namespace Tests\Unit;

use App\Models\Label;
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
        $this->task1 = Task::factory()->create(['created_by_id' => $this->user1->id]);
        $this->label1 = Label::factory()->create(['name' => 'FirstLabel', 'description' => 'FirstLabelDesc']);
    }

    /** @test */
    public function createTask(): void
    {
        $response = $this->get('/tasks/create');
        $response->assertOk();
        $response->assertSee('Создать');
    }


    /** @test */
    public function editTask(): void
    {
        $taskid = $this->task1->id;
        $response = $this->get("/tasks/{$taskid}/edit");
        $response->assertOk();

        Auth::login($this->user2);

        $response = $this->get("/tasks/{$taskid}/edit");
        $response->assertRedirect();
    }

    /** @test */
    public function updateTask(): void
    {
        $this->followingRedirects();
        $newData = ['name' => 'New name', 'description' => 'New description'];
        $response = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response->assertSee("Это обязательное поле");

        $this->followingRedirects();
        $newData['status_id'] = $this->status1->id;
        $newData['assigned_to_id'] = $this->user2->id;
        $response2 = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response2->assertSee('Задача успешно изменена');

        $this->followingRedirects();
        $newData['labels'] = [$this->label1->id];
        $response3 = $this->patch("/tasks/{$this->task1->id}", $newData);
        $response3->assertSee('Задача успешно изменена');
    }

    /** @test */
    public function deleteTask(): void
    {
        $this->followingRedirects();
        $taskid = $this->task1->id;
        $response = $this->delete("/tasks/{$taskid}");
        $response->assertSee("Задача успешно удалена");
    }
}
