<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LabelsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function aUserCanBrowseLabels()
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }

    /** @test */
    public function anUnauthorizedUserCantCreateLabel()
    {
        $label = Label::factory()->make();

        $this->followingRedirects();

        $response = $this->post('/labels', $label->toArray());
        $response->assertOk();
        $response->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function anAuthorizedUserCanCreateLabel()
    {
        $user = User::factory()->create();
        $label = Label::factory()->make();

        Auth::login($user);

        $this->followingRedirects();

        $response = $this->post('/labels', $label->toArray());
        $response->assertOk();
        $response->assertSee('Метка успешно создана');
    }
}
