<?php

namespace App\Http\Controllers;

use App\Enum\Status;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Liste de l’ensemble des profils
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return ProfileResource::collection(Profile::query()
            ->with('comment')
            ->where('status', Status::ACTIVE->value)
            ->get());
    }

    /**
     * Créer une entité profil.
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function store(ProfileRequest $request): JsonResponse
    {
        $path = $request->file('image')->store('images', 'public');

        $profile = $request->user()->profiles()->create([
            'name' => $request->get('name'),
            'firstname' => $request->get('firstname'),
            'image_path' => $path,
            'status' => $request->get('status')
        ]);

        return response()->json(['profiles' => new ProfileResource($profile), 200]);
    }

    /**
     * Modifier un profil
     * @param Profile $profile
     * @param ProfileRequest $request
     * @return JsonResponse
     */
    public function update(Profile $profile, ProfileRequest $request): JsonResponse
    {
        if (Storage::exists('public/'.$profile->image_path)) {
            Storage::delete('public/'.$profile->image_path);
        }

        $path = $request->file('image')->store('images', 'public');

        $profile->update([
            'name' => $request->get('name'),
            'firstname' => $request->get('firstname'),
            'image_path' => $path,
            'status' => $request->get('status')
        ]);

        return response()->json(['profiles' => new ProfileResource($profile), 200]);
    }

    /**
     * Supprimer un profil
     * @param Profile $profile
     * @return JsonResponse
     */
    public function delete(Profile $profile): JsonResponse
    {
        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}
