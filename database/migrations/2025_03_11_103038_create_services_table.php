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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_tableauService')  // Lien vers le tableau de service
                ->constrained('tableau_service')
                ->onDelete('cascade');  // Supprimer les services liés lors de la suppression du tableau de service
            $table->foreignId('id_user')  // Lien vers l'utilisateur (technicien)
                ->constrained('users')
                ->onDelete('cascade');  // Supprimer les services liés lors de la suppression de l'utilisateur
            $table->time('heure_debut');  // Heure de début du service
            $table->time('heure_fin');    // Heure de fin du service
            $table->date('date_service'); // Date du service
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
