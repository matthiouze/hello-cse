<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Ajout d'un commentaire sur un profil.
     * @param Profile $profile
     * @param CommentRequest $request
     * @return JsonResponse
     */
    public function store(Profile $profile, CommentRequest $request): JsonResponse
    {
        $comment = $profile->comments()->create([
            'content' => $request->get('content'),
            'admin_id' => $request->user()->id,
        ]);

        return response()->json(['comment' => new CommentResource($comment), 200]);
    }
}
