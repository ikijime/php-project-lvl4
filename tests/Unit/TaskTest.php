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

    private mixed $task1;
    private mixed $label1;
    private mixed $status1;
    private mixed $user1;
    private mixed $user2;

    public function setUp(): void
    {
        parent::setUp();

        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);

        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);

        $this->task1 = Task::factory()->create(['created_by_id' => $this->user1->id]);
        $this->label1 = Label::factory()->create(['name' => 'FirstLabel', 'description' => 'FirstLabelDesc']);
    }

    /** @test */
    public function createTaskMustBeAuthenticated(): void
    {
        $this->followingRedirects()
            ->get('/tasks/create')
            ->assertOk()
            ->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function createTask(): void
    {
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->get('/tasks/create')
            ->assertOk()
            ->assertSee('Создать');
    }

    /** @test */
    public function editTask(): void
    {
        $this->actingAs($this->user1)->get(route('tasks.edit', $this->task1->id))
            ->assertOk();

        $this->actingAs($this->user2)
            ->get(route('tasks.edit', $this->task1->id))
            ->assertRedirect();
    }

    /** @test */
    public function updateTask(): void
    {
        $newData = ['name' => 'New name', 'description' => 'New description'];
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->patch(route('tasks.update', $this->task1->id), $newData)
            ->assertSee("Это обязательное поле");

        $newData['status_id'] = $this->status1->id;
        $newData['assigned_to_id'] = $this->user2->id;
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->patch(route('tasks.update', $this->task1->id), $newData)
            ->assertSee('Задача успешно изменена');

        $newData['labels'] = [$this->label1->id];
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->patch(route('tasks.update', $this->task1->id), $newData)
            ->assertSee('Задача успешно изменена');
    }

    /** @test */
    public function deleteTask(): void
    {
        $taskid = $this->task1->id;
        $this->actingAs($this->user1)
            ->followingRedirects()
            ->delete(route('tasks.destroy', $taskid))
            ->assertSee("Задача успешно удалена");
    }
}
