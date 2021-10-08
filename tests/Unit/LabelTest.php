<?php

namespace Tests\Unit;

use App\Models\Label;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function label_created_with_name(): void
    {
        $label = Label::factory()->create(['name' => 'label1']);
        $this->assertEquals('label1', $label->name);
    }
}
