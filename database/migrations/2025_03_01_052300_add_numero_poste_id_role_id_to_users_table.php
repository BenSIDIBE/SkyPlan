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
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('numero')->nullable();
            $table->string('matricule')->unique()->nullable();

            $table->foreignId('poste_id')->nullable()->constrained('postes')->onDelete('set null');
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropForeign(['poste_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn(['numero', 'matricule', 'poste_id', 'role_id']);
        });
    }
};
