<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TaskStatusTest  extends TestCase
{
    use DatabaseMigrations;
    public function setUp(): void
    {
        parent::setUp();
        
        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);

        Auth::login($this->user1);
        $this->status1 = TaskStatus::factory()->create(['name' => 'FirstStatus']);
        $this->status2 = TaskStatus::factory()->create(['name' => 'SecondStatus']);
    }

    /** @test */
    public function task_status_create(): void
    {
        $response = $this->get('/task_statuses/create');
        $response->assertOk();
    }

    /** @test */
    public function task_status_show(): void
    {
        $response = $this->get("/task_statuses/{$this->status1->id}");
        $response->assertRedirect();
    }
}
