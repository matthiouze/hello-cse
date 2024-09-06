<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Facades\Storage;

class ProfileObserver
{
    /**
     * Supprime l'image du profil lors de la suppression du profil
     * @param Profile $profile
     * @return void
     */
    public function deleting(Profile $profile): void
    {
        if (Storage::exists('public/'.$profile->image_path)) {
            Storage::delete('public/'.$profile->image_path);
        }
    }
}
