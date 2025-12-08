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
        Schema::create('maintenances', function (Blueprint $table): void {
            $table->id();
            $table->enum('type', ['préventive', 'corrective'])->default('préventive');
            $table->text('description')->nullable();
            $table->date('date_planifiee')->nullable();
            $table->enum('statut', ['planifiee', 'en cours', 'terminee', 'annulee'])
                ->default('planifiee');

            $table->foreignId('engin_id')
                ->constrained('engins')
                ->onDelete('cascade'); // Assure que la maintenance est supprimée si l'engin est supprimé
            $table->foreignId('technicien_id')->nullable()
                ->constrained('users')
                ->onDelete('set null'); // Assure que la maintenance reste même si le technicien est supprimé
            $table->timestamps();
            $table->foreignId('incident_id')->nullable()->constrained('incidents')->onDelete('set null');
            $table->foreignId('responsable_id')->nullable()
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->foreignId('maintenance_automatique_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
