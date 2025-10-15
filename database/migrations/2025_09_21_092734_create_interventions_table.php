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
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_debut');
            $table->dateTime('date_fin')->nullable();
            $table->text('description')->nullable();
            $table->enum('etat_post_maintenance', ['fonctionnel', 'non fonctionnel'])->nullable();

            $table->foreignId('maintenance_id')
                ->constrained('maintenances')
                ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('interventions');
    }
};
