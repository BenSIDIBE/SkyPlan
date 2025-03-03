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
        //
        Schema::create('tableau_de_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('quart_id')->constrained('quarts');
            $table->json('heure_debut'); // Tableau d'heures de début
            $table->json('heure_fin');   // Tableau d'heures de fin
            $table->json('week');        // Tableau de jours
            $table->date('date_service');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */

    public function down(): void
    {
        Schema::dropIfExists('tableau_de_services');
    }
};
