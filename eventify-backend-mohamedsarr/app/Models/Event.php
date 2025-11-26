<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    use HasFactory;
    
    // Définir les champs autorisés à la modification de masse (Mass Assignment)
    protected $fillable = [
        'title',
        'description',
        'location',
        'date_time',
        'is_public',
        'user_id', // L'ID de l'organisateur
    ];

    /**
     * Relation 1: L'utilisateur qui a organisé cet événement.
     * Un événement appartient à un seul organisateur. (Belongs-To)
     */
    public function users(): BelongsTo
    {
        // 'user_id' est la clé étrangère dans la table 'events'
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation 2: Les utilisateurs (participants) inscrits à cet événement.
     * Un événement peut avoir plusieurs participants. (Many-to-Many)
     */
    public function users(): BelongsToMany
    {
        // Utilise la table pivot 'registrations' et les clés par défaut
<<<<<<< HEAD
        return $this->belongsToMany(
            User::class,
            'registrations',
            'event_id',
            'user_id'
        );
=======
        return $this->belongsToMany(User::class, 'registrations'
                                                 'event_id',
                                                 'user_id'
                                   );
>>>>>>> f13ca709289e4f41531592e10cb44d905cf2220d
    }
}
