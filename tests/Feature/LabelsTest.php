<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LabelsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function aUserCanBrowseLabels(): void
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }

    /** @test */
    public function anUnauthorizedUserCantCreateLabel(): void
    {
        $label = Label::factory()->make();

        $this->followingRedirects();

        $this->post(route('labels.index'), $label->toArray())
        ->assertOk()
        ->assertSee('Для просмотра необходима аутентификация');
    }

    /** @test */
    public function anAuthorizedUserCanCreateLabel(): void
    {
        $user = User::factory()->create();
        $label = Label::factory()->make();

        $this->actingAs($user)
            ->followingRedirects()
            ->post(route('labels.index'), $label->toArray())
            ->assertSee('Метка успешно создана');
    }
}
