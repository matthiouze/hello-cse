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
        $user = Admin::factory()->isAdmin()->create();

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

    /**
     * test si un user est admin
     */
    public function test_user_is_not_admin(): void
    {
        $user = Admin::factory()->create();

        $response = $this->post('api/profiles', [
            'name' => fake()->name,
            'firstname' => fake()->firstName,
            'image_path' => fake()->imageUrl(),
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        $response->assertStatus(403);
    }
}
