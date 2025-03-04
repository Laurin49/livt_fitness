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
        Schema::create('exercise_workout', function (Blueprint $table) {
            $table->primary(['exercise_id', 'workout_id']);     // verhindert das doppelte Einträge in der Tabelle vorkommen
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->foreignId('workout_id')->constrained('workouts')->onDelete('cascade');
            $table->text('beschreibung')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercise_workout');
    }
};
