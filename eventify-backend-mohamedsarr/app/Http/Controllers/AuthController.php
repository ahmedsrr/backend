<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // ==========================================
    // 1. MÉTHODE REGISTER (Inscription)
    // ==========================================
    public function register(Request $request)
    {
        // A. Validation des données envoyées par Postman/Frontend
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // L'email doit être unique
            'password' => 'required|string|min:6|confirmed', // 'confirmed' exige un champ 'password_confirmation'
            'role' => 'nullable|in:organizer,participant' // Le rôle est optionnel, mais s'il est là, il doit être valide
        ]);

        // B. Création de l'utilisateur dans la Base de Données
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']), // On crypte le mot de passe
            'role' => $validatedData['role'] ?? 'participant', // Rôle par défaut : participant
        ]);

        // C. Création du Token (Jeton) pour que l'utilisateur soit connecté directement
        $token = $user->createToken('auth_token')->plainTextToken;

        // D. Réponse JSON envoyée au client
        return response()->json([
            'message' => 'Utilisateur créé avec succès.',
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201); // 201 signifie "Créé"
    }

    // ==========================================
    // 2. MÉTHODE LOGIN (Connexion)
    // ==========================================
    public function login(Request $request)
    {
        // Validation simple
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Vérification des identifiants
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Identifiants invalides'
            ], 401); // 401 signifie "Non autorisé"
        }

        // Si c'est bon, on récupère l'utilisateur et on crée un token
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Connexion réussie.',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ]);
    }

    // ==========================================
    // 3. MÉTHODE LOGOUT (Déconnexion)
    // ==========================================
    public function logout(Request $request)
    {
        // Supprime le token actuel
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie'
        ]);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
