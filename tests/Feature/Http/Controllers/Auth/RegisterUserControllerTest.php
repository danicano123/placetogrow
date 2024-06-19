<?php

namespace Tests\Feature\Http\Controllers\Auth;

use Tests\TestCase;

class RegisterUserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/api/register');

        $response->assertStatus(201);
    }
}
