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
        Schema::create('daily_usages', function (Blueprint $table): void {
            $table->id();
            $table->date('date_usage');
            $table->string('site_destination');
            $table->boolean('is_returned')->default(false);
            $table->text('observation_depart')->nullable();
            $table->dateTime('heure_sortie');
            $table->dateTime('heure_retour')->nullable();
            $table->decimal('compteur_h_sortie', 9, 2);
            $table->decimal('compteur_km_sortie', 9, 2);
            $table->decimal('compteur_h_retour', 9, 2)->nullable();
            $table->decimal('compteur_km_retour', 9, 2)->nullable();
            $table->text('observation_retour')->nullable();
            $table->decimal('carburant_rempli_l', 8, 2)->nullable(); // Consommation en litres, nullable si non applicable

            $table->foreignId('engin_id')
                ->constrained('engins')
                ->onDelete('cascade');
            $table->foreignId('agent_suivi_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('operateur_id')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_usages');
    }
};
