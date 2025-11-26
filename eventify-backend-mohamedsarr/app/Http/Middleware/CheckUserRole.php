<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role  // Récupère le rôle attendu passé dans la route
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Vérification de l'Authentification (auth()->check())
        // Si l'utilisateur n'est pas connecté, l'erreur est gérée par le middleware 'auth:sanctum'
        if (! Auth::check()) {
            return response()->json([
                'message' => 'Non authentifié. Veuillez vous connecter.'
            ], 401);
        }

        // 2. Vérification du Rôle
        // Si le rôle de l'utilisateur (auth()->user()->role) ne correspond PAS au rôle attendu ($role)
        if (Auth::user()->role !== $role) {
            // Logique du Cahier des Charges : Retourner une erreur 403 (Accès Interdit)
            return response()->json([
                'message' => 'Accès interdit. Vous n\'avez pas le rôle requis pour cette action.'
            ], 403);
        }

        // Si l'utilisateur est authentifié et que le rôle correspond, la requête continue
        return $next($request);
    }
}