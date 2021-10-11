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
        $label1 = Label::factory()->create(['name' => 'label1']);
        $label2 = Label::factory()->create(['name' => 'label2']);
        $this->assertEquals('label1', $label1->name);
        $this->assertEquals('label2', $label2->name);
    }
}
