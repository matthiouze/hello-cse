<?php

namespace Tests\Feature;

use App\Models\Admin;
use Tests\TestCase;

class AdminTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_has_token(): void
    {
        $user = Admin::query()->first();

        $response = $this->post('api/login', [
            'email' => $user->email,
            'password' => 'azeaze'
        ]);

        $response->assertJsonStructure([
            'token',
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_user_not_found(): void
    {
        $response = $this->post('api/login', [
            'email' => 'fake@email.com',
            'password' => 'azeaze'
        ]);

        $response->assertStatus(401);
    }
}
