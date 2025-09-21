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
        Schema::create('alert_maintenances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engin_id')->constrained()->cascadeOnDelete();
            $table->foreignId('maintenance_automatique_id')->constrained('maintenance_automatiques')->cascadeOnDelete();
            $table->decimal('compteur_declencheur', 10, 2);
            $table->enum('statut', ['nouvelle', 'planifiee'])->default('nouvelle');
            $table->enum('type', ['horaire', 'km'])
                ->default('horaire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_maintenances');
    }
};
