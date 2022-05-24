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

    private mixed $user;
    private mixed $status;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->make(['name' => 'UniqueName']);
    }

    /** @test */
    public function aUserCanBrowseStatuses(): void
    {
        $this->get(route('task_statuses.index'))->assertStatus(200);
    }

    /** @test */
    public function anAuthorizedUserCanCreateStatus(): void
    {
        $this->actingAs($this->user)
        ->followingRedirects()
        ->post(route('task_statuses.index'), $this->status->toArray())
        ->assertSee($this->status->name);
    }
}
