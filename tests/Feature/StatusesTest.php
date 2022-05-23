<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusesTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->make(['name' => 'UniqueName']);
    }

    /** @test */
    public function aUserCanBrowseStatuses()
    {
        $this->get('/task_statuses')->assertStatus(200);
    }

    /** @test */
    public function anAuthorizedUserCanCreateStatus()
    {
        Auth::login($this->user);
        $this->followingRedirects()
        ->post('/task_statuses', $this->status->toArray())
        ->assertSee($this->status->name);
    }
}
