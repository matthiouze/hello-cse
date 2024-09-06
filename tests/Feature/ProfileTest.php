<?php

namespace Feature;

use App\Models\Admin;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * test si l'index de profileController retourne une ressource
     */
    public function test_index_return_ressource(): void
    {
        $response = $this->get('api/profiles');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'firstname',
                    'image_path',
                    'created_at',
                    'updated_at',
                    'commment',
                ],
            ],
        ]);
    }

    /**
     * test si un profile est bien stocké
     */
    public function test_profile_is_stored(): void
    {
        $user = Admin::factory()->isAdmin()->create();

        Storage::fake('public');

        $response = $this->post('api/profiles', [
            'name' => fake()->name,
            'firstname' => fake()->firstName,
            'status' => 'pending',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
           'profile' => [
                'id',
                'name',
                'firstname',
                'image_path',
                'created_at',
                'updated_at',
                'commment',
            ],
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_store_has_failed(): void
    {
        $user = Admin::factory()->isAdmin()->create();

        Storage::fake('public');

        $response = $this->post('api/profiles', [
            'status' => 'pending',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        $response->assertStatus(500);
    }

    /**
     * test si un profile est bien stocké
     */
    public function test_profile_is_updated(): void
    {
        $user = Admin::factory()->isAdmin()->create();

        Storage::fake('public');

        $profile = Profile::factory()->create();

        $response = $this->put('api/profiles/'.$profile->id, [
            'name' => fake()->name,
            'firstname' => fake()->firstName,
            'status' => 'pending',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'profile' => [
                'id',
                'name',
                'firstname',
                'image_path',
                'created_at',
                'updated_at',
                'commment',
            ],
        ]);
    }

    /**
     * test si un profile est bien supprimé
     */
    public function test_delete_a_profile()
    {
        $user = Admin::factory()->isAdmin()->create();

        Storage::fake('public');

        $profile = $this->post('api/profiles', [
            'name' => fake()->name,
            'firstname' => fake()->firstName,
            'status' => 'pending',
            'image' => UploadedFile::fake()->image('profile.jpg'),
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        $response = $this->delete('api/profiles/'.$profile->json('profile.id'), [], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        // Vérifier que le message de succès est retourné
        $response->assertJson(['message' => 'Profile deleted successfully']);
    }
}
