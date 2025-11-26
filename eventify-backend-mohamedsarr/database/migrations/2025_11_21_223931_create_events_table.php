<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Clé primaire auto-incrémentée (id)

            // Clé Étrangère vers l'organisateur (user_id)
            // Relie l'événement à la table 'users'. 'onDelete('cascade')' supprime les événements si l'organisateur est supprimé.
            $table->foreignId('user_id') 
                  ->constrained('users') // Assurez-vous que votre table utilisateur s'appelle 'users'
                  ->onDelete('cascade');

            // Champs de l'événement (requis)
            $table->string('title', 255);
            $table->text('description')->nullable(); // Utiliser 'text' pour les longues descriptions, 'nullable()' permet que ce champ soit vide.
            $table->string('location');
            $table->dateTime('date_time'); // Utiliser dateTime pour la date et l'heure précises

            // Champ booléen (requis)
            $table->boolean('is_public')->default(true); // 'default(true)' pour que l'événement soit public par défaut

            $table->timestamps(); // Crée les colonnes 'created_at' et 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
