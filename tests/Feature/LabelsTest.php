<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LabelsTest extends TestCase
{
    /** @test */
    use DatabaseMigrations;

    public function a_user_can_browse_labels()
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }

    /** @test */
    use DatabaseMigrations;

    public function an_unauthorized_user_cant_create_label()
    {
        $label = Label::factory()->make();

        $this->followingRedirects();

        $response = $this->post('/labels', $label->toArray());
        $response->assertOk();
        $response->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function an_authorized_user_can_create_label()
    {
        $user = User::factory()->create();
        $label = Label::factory()->make();

        Auth::login($user);

        $this->followingRedirects();

        $response = $this->post('/labels', $label->toArray());
        $response->assertOk();
        $response->assertSee('New label created');
    }
}
