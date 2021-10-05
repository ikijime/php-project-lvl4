<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StatusesTest extends TestCase
{
    /** @test */
    use DatabaseMigrations;

    public function a_user_can_browse_statuses()
    {
        $response = $this->get('/task_statuses');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_authorized_user_can_create_status()
    {
        $user = User::factory()->create();

        $status = TaskStatus::factory()->create();

        $this->followingRedirects();

        Auth::login($user);
        
        $response = $this->post('/task_statuses', $status->toArray());
        $response->assertSee($status->name);
    }
}
