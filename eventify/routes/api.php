<?php

// routes/api.php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;

// --- Routes d'Authentification Publiques ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// --- Routes d'Événements Publiques (Catalogue) ---
Route::get('/events', [EventController::class, 'index']); // GET /api/events
Route::get('/events/{event}', [EventController::class, 'show']); // GET /api/events/{id}


// --- Routes Protégées (Nécessitent un Token Sanctum) ---
Route::middleware('auth:sanctum')->group(function () {
    
    // Déconnexion
    Route::post('/logout', [AuthController::class, 'logout']); 

    // Inscription aux événements (accessible à tout utilisateur authentifié)
    Route::post('/events/{event}/register', [EventController::class, 'register']);
    // Créer une route pour les inscriptions des participants
    Route::get('/registrations', [EventController::class, 'myRegistrations']);
    // --- Routes Organisateur (Nécessitent le Rôle 'organizer') ---
    Route::middleware('role:organizer')->group(function () {
        
        // CRUD Complet (pour la création, modification et suppression)
        Route::post('/events', [EventController::class, 'store']);
        Route::put('/events/{event}', [EventController::class, 'update']);
        Route::delete('/events/{event}', [EventController::class, 'destroy']);
        
        // Dashboard de l'organisateur
        Route::get('/organizer/my-events', [EventController::class, 'showDashboard']); 
    });
});
