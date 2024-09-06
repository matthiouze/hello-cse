<?php

namespace Feature;

use App\Models\Admin;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_comment_has_been_added_to_a_profile()
    {
        $user = Admin::factory()->isAdmin()->create();

        $profile = Profile::factory()->create();

        $response = $this->post("/api/profiles/{$profile->id}/comments", [
            'content' => 'This is a comment',
        ], [
            'Authorization' => 'Bearer '.$user->createToken($user->email)->plainTextToken,
        ]);

        // Assert: Vérifier le statut HTTP
        $response->assertStatus(200);

        // Assert: Vérifier que le commentaire est bien enregistré dans la base de données
        $response->assertJsonStructure([
            'comment' => [
                'id',
                'content',
                'profile_id',
                'admin_id',
            ]
        ]);

        // Assert: Vérifier que la réponse JSON est correcte
        $response->assertJsonStructure([
            'comment' => [
                'id', 'content', 'profile_id', 'admin_id', 'created_at', 'updated_at'
            ]
        ]);
    }
}
