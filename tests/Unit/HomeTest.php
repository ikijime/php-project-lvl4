<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Label;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends TestCase
{
    /** @test */
    public function showLabel(): void
    {
        $response = $this->get("/");
        $response->assertOk();
    }
}
