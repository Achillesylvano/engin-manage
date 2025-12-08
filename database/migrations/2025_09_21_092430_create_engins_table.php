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
        Schema::create('engins', function (Blueprint $table): void {
            $table->id();
            $table->string('designation')->nullable();
            $table->string('marque')->nullable();
            $table->string('modele')->nullable();
            $table->string('numero_serie')->unique();
            $table->decimal('compteur_h', 10, 2)->default(0.00);
            $table->decimal('compteur_km', 10, 2)->default(0.00);
            $table->decimal('capacite_reservoir', 8, 2)->nullable();
            $table->enum('type_carburant', ['diesel', 'essence'])->default('diesel');
            $table->enum('etat', ['operationnel', 'en_maintenance', 'hors_service', 'en_panne'])->default('operationnel');
            $table->date('date_acquisition');
            $table->string('image_engin')->nullable();

            $table->foreignId('type_engin_id')->constrained('type_engins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engins');
    }
};
