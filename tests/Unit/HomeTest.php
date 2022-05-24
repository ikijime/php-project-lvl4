<?php

namespace Tests\Unit;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    public function showLabel(): void
    {
        $response = $this->get("/");
        $response->assertOk();
    }
}
