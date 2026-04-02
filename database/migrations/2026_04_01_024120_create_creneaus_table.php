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
    Schema::create('creneaus', function (Blueprint $table) {
        $table->id();
        $table->foreignId('medecin_id')->constrained('users')->onDelete('cascade');
        $table->date('date');
        $table->time('heure');
        $table->enum('statut', ['libre', 'reserve'])->default('libre');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('creneaus');
    }
};
