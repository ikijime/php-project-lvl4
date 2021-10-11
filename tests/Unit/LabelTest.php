<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LabelTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        
        $this->user1 = User::factory()->create(['name' => 'FirstUser']);
        $this->user2 = User::factory()->create(['name' => 'SecondUser']);
        $this->label1 = Label::factory()->create(['name' => 'label1']);
        $this->label2 = Label::factory()->create(['name' => 'label2']);
        Auth::login($this->user1);
    }

    /** @test */
    public function create_label(): void
    {
        $response = $this->get('/labels/create');
        $response->assertOk();
    }

    /** @test */
    public function create_not_authorized_label(): void
    {
        Auth::logout();
        $this->followingRedirects();
        $response = $this->get('/labels/create');
        $response->assertSee('Для просмотра необходима аутентификация.');
    }

    /** @test */
    public function edit_label(): void
    {
        $response = $this->get("/labels/{$this->label1->id}/edit");
        $response->assertOk();
    }

    /** @test */
    public function update_label(): void
    {
        $this->followingRedirects();
        $label = $this->label1->toArray();
        $label['name'] = 'UpdatedName';
        $response = $this->patch("/labels/{$this->label1->id}", $label);
        $response->assertOk();
        $response->assertSee('UpdatedName');
    }

    /** @test */
    public function show_label(): void
    {
        $response = $this->get("/labels/{$this->label1->id}");
        $response->assertRedirect();
    }

    /** @test */
    public function delete_label(): void
    {
        $this->delete("/labels/{$this->label1->id}");
        $this->assertDatabaseMissing('labels', ['name' => 'label1']);
    }
}
