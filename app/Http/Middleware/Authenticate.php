<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Ne redirige pas pour les requêtes API
        if ($request->is('api/*')) {
            return null;
        }

        return $request->expectsJson() ? null : route('login');
    }

    /**
     * Handle unauthenticated user for API routes.
     */
    protected function unauthenticated($request, array $guards)
    {
        // Si la requête est une API, retourne une réponse JSON
        if ($request->is('api/*')) {
            abort(response()->json(['message' => 'Unauthorized'], 401));
        }

        // Pour les autres requêtes, utiliser le comportement par défaut
        parent::unauthenticated($request, $guards);
    }
}
