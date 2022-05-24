<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LabelTest extends TestCase
{
    use DatabaseMigrations;

    private mixed $user1;
    private mixed $label1;

    public function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->label1 = Label::factory()->create(['name' => 'label1']);
    }

    /** @test */
    public function createLabel(): void
    {
        $this->actingAs($this->user1)
            ->get('/labels/create')
            ->assertOk();
    }

    /** @test */
    public function createNotAuthorizedLabel(): void
    {
        $this->followingRedirects();
        $response = $this->get('/labels/create');
        $response->assertSee('Для просмотра необходима аутентификация.');
    }

    /** @test */
    public function editLabel(): void
    {
        $this->actingAs($this->user1)
            ->get("/labels/{$this->label1->id}/edit")
            ->assertOk();
    }

    /** @test */
    public function updateLabel(): void
    {
        $label = Arr::only($this->label1->toArray(), ['name', 'description']);
        $label['name'] = 'UpdatedName';

        $this->actingAs($this->user1)
            ->patch(route('labels.update', $this->label1), $label)
            ->assertRedirect();
        $this->assertDatabaseHas('labels', $label);
    }

    /** @test */
    public function showLabel(): void
    {
        $response = $this->get("/labels/{$this->label1->id}");
        $response->assertRedirect();
    }

    /** @test */
    public function deleteLabel(): void
    {
        $this->actingAs($this->user1)->delete("/labels/{$this->label1->id}");
        $this->assertDatabaseMissing('labels', ['name' => 'label1']);
    }
}
