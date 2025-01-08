<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importez la classe Log

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Ajoutez une instruction de débogage pour vérifier si le middleware est atteint
        Log::info('Authenticate middleware reached');

        // Ajoutez une instruction de débogage pour voir la demande entrante
        Log::info('Request:', $request->all());

        // Ajoutez une instruction de débogage pour vérifier si l'utilisateur est authentifié
        if (!auth()->check()) {
            Log::info('User is not authenticated');
        }

        // Redirigez l'utilisateur vers la page de connexion
        return $request->expectsJson() ? null : route('login');
    }
}
