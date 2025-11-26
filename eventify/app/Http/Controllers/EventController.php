<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    // =================================================================
    // PARTIE PUBLIQUE (Accessible à tous)
    // =================================================================

    /**
     * Liste tous les événements publics (Catalogue)
     * GET /api/events
     */
<<<<<<< HEAD
    public function index()
{
    // Seuls les événements is_public = true sont affichés pour le catalogue
    $events = Event::where('is_public', true)
                   ->orderBy('date_time', 'asc')
                   ->get();

    return response()->json($events);
}
    public function show($id)
    {
=======
    {
    // Seuls les événements is_public = true sont affichés pour le catalogue
    $events = Event::where('is_public', true)
                   ->orderBy('date_time', 'asc')
                   ->get();

    return response()->json($events);
}
    public function show($id)
    {
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
        $event = Event::with('organizer:id,name')->find($id);

        if (!$event) {
            return response()->json(['message' => 'Événement introuvable'], 404);
        }

        // Si l'événement est privé ET que l'utilisateur n'est pas l'organisateur
        if (!$event->is_public && Auth::id() !== $event->user_id) {
             return response()->json(['message' => 'Accès non autorisé à cet événement privé'], 403);
        }

        return response()->json($event, 200);
    }

    // =================================================================
    // PARTIE ORGANISATEUR (Nécessite le rôle 'organizer')
    // =================================================================

    /**
     * 
     * * Créer un nouvel événement
     * POST /api/events
     */
    public function store(Request $request)
    {
        // 1. Validation
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'date_time' => 'required|date|after:now', // La date doit être dans le futur
            'is_public' => 'boolean'
        ]);

        // 2. Création (Liaison automatique avec l'utilisateur connecté)
        // On utilise la relation 'organizes' définie dans le modèle User
        $event = Auth::user()->organizes()->create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'location' => $fields['location'],
            'date_time' => $fields['date_time'],
            'is_public' => $fields['is_public'] ?? true, // Public par défaut
        ]);

        return response()->json([
            'message' => 'Événement créé avec succès',
            'event' => $event
        ], 201);
    }

    /**
     * Mettre à jour un événement
     * PUT /api/events/{id}
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Événement introuvable'], 404);
        }

        // SÉCURITÉ : Vérifier que l'utilisateur est bien le propriétaire
        if (Auth::id() !== $event->user_id) {
            return response()->json(['message' => 'Vous n\'êtes pas l\'organisateur de cet événement'], 403);
        }

        // Validation (tous les champs sont optionnels lors d'une mise à jour)
        $fields = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'location' => 'sometimes|string',
            'date_time' => 'sometimes|date|after:now',
            'is_public' => 'sometimes|boolean'
        ]);

        $event->update($fields);

        return response()->json([
            'message' => 'Événement mis à jour',
            'event' => $event
        ], 200);
    }

    /**
     * Supprimer un événement
     * DELETE /api/events/{id}
     */
    public function destroy($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Événement introuvable'], 404);
        }

        // SÉCURITÉ : Vérifier propriété
        if (Auth::id() !== $event->user_id) {
            return response()->json(['message' => 'Action non autorisée'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Événement supprimé'], 200);
    }
    /**
     * DASHBOARD : Voir tous les événements que j'ai créés (Publics et Privés)
     * GET /api/organizer/my-events
     */
    public function showDashboard()
    {
        // Récupère l'utilisateur connecté
        $user = Auth::user();

        // Récupère les événements créés par cet utilisateur
        // withCount('users') permet de savoir combien de participants sont inscrits (pour les stats du dashboard)
        $events = $user->organizes()->withCount('users')->orderBy('date_time', 'desc')->get();

        return response()->json($events);
    }
    // =================================================================
    // PARTIE PARTICIPANT (Inscription)
    // =================================================================

    /**
     * S'inscrire à un événement
     * POST /api/events/{id}/register
     */
    public function register($id)
    {
        $event = Event::find($id);

        if (!$event) {
            return response()->json(['message' => 'Événement introuvable'], 404);
        }

        $user = Auth::user();

        // 1. Empêcher l'organisateur de s'inscrire à son propre événement (optionnel)
        if ($user->id === $event->user_id) {
            return response()->json(['message' => 'Vous êtes l\'organisateur de cet événement'], 409);
        }

        // 2. Vérifier si déjà inscrit (éviter les doublons)
        // On utilise la relation 'participatesIn' définie dans le modèle User
        $alreadyRegistered = $user->participatesIn()
                                  ->where('event_id', $id)
                                  ->exists();

        if ($alreadyRegistered) {
            return response()->json(['message' => 'Vous êtes déjà inscrit à cet événement'], 409);
        }

        // 3. Inscription (Ajout dans la table pivot 'registrations')
        $user->participatesIn()->attach($id);

        return response()->json(['message' => 'Inscription validée !'], 200);
    }
    
    /**
     * (Bonus) Voir mes inscriptions
     * GET /api/my-registrations
     */
    public function myRegistrations() {
        $user = Auth::user();
        // Récupère les événements auxquels je participe
        $events = $user->participatesIn()->get();
        return response()->json($events);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
