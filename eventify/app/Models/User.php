<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    // Assurez-vous d'avoir 'role' dans $fillable si vous le gérez lors de l'inscription.
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // IMPORTANT: Permet d'enregistrer le rôle
    ];

    // ... autres propriétés (hidden, casts)

    /**
     * Relation 1: Les événements que cet utilisateur organise.
     * Un utilisateur (Organisateur) peut avoir plusieurs événements. (One-to-Many)
     */
    public function organizes(): HasMany
    {
        // 'user_id' est la clé étrangère dans la table 'events'
        return $this->hasMany(Event::class);
    }

    /**
     * Relation 2: Les événements auxquels cet utilisateur participe.
     * Un utilisateur (Participant) peut s'inscrire à plusieurs événements (Many-to-Many)
     */
    public function participatesIn(): BelongsToMany
    {
        // Utilise la table pivot 'registrations' et les clés par défaut 'user_id' et 'event_id'
        return $this->belongsToMany(Event::class, 'registrations');
    }
}