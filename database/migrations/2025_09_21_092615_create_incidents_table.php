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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_signalement');
            $table->text('description')->nullable();
            $table->enum('niveau_gravite', ['critique', 'majeur', 'mineur']);
            $table->boolean('resolu')->default(false);
            $table->date('date_resolution')->nullable();

            $table->foreignId('engin_id')->constrained('engins');
            $table->foreignId('operateur_id')->constrained('users')->nullable();
            $table->foreignId('daily_usage_id')->nullable()->constrained('daily_usages')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
