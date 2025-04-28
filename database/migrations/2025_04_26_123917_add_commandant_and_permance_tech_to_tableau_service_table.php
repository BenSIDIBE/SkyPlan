

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tableau_service', function (Blueprint $table) {
            $table->string('commandant_permanence')->nullable()->after('user_id');
            $table->string('permanence_tech')->nullable()->after('commandant_permanence');
        });
    }

    public function down(): void
    {
        Schema::table('tableau_service', function (Blueprint $table) {
            $table->dropColumn(['commandant_permanence', 'permanance_tech']);
        });
    }
};

