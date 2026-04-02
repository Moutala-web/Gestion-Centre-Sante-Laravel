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
    Schema::table('rendez_vous', function (Blueprint $table) {
        // On ajoute la colonne qui servira de lien direct avec le créneau
        $table->foreignId('disponibilite_id')->nullable()->constrained('disponibilites')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
   public function down(): void
{
    Schema::table('rendez_vous', function (Blueprint $table) {
        $table->dropForeign(['disponibilite_id']);
        $table->dropColumn('disponibilite_id');
    });
}
};
