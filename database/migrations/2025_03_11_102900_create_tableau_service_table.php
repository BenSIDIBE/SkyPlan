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
        Schema::create('tableau_service', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');  // Date de début du tableau de service
            $table->date('date_fin');    // Date de fin du tableau de service
            $table->json('week')->default(json_encode([
                "Lundi",
                "Mardi",
                "Mercredi",
                "Jeudi",
                "Vendredi",
                "Samedi",
                "Dimanche"
            ]));
            $table->json('jour_ferie');  // Jours fériés
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tableau_service');
    }
};
