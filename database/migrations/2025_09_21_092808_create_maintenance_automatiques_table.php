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
        Schema::create('maintenance_automatiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('engin_id')->constrained('engins')->cascadeOnDelete();
            $table->enum('type', ['horaire', 'km']);
            $table->decimal('seuil', 10, 2);
            $table->text('description'); // liste des tâches à faire
            $table->decimal('dernier_compteur', 10, 2)->default(0);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_automatiques');
    }
};
