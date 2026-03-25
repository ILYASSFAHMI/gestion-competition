<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team1_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('team2_id')->constrained('teams')->cascadeOnDelete();
            $table->enum('field', ['foot', 'ctf', 'baskett', 'chess', 'volley ball', 'Esport']);
            $table->dateTime('match_date');
            $table->enum('status', ['upcoming', 'live', 'finished'])->default('upcoming');
            $table->integer('team1_score')->nullable();
            $table->integer('team2_score')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
