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
    Schema::create('rendez_vous', function (Blueprint $table) {
        $table->id();
        // Le médecin (clé étrangère vers users)
        $table->foreignId('medecin_id')->constrained('users');
        // Le patient
        $table->foreignId('patient_id')->constrained('patients')->onDelete('cascade');
        
        $table->date('date');
        $table->time('heure');
        $table->string('motif');
        $table->enum('statut', ['en_attente', 'termine', 'annule'])->default('en_attente');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
