<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');          // Nom de l'école
            $table->string('join_code');     // Code pour rejoindre l'équipe
            $table->enum('field', ['foot', 'ctf', 'baskett', 'chess', 'volley ball', 'Esport']); // Le domaine/sport
            $table->unsignedInteger('max_members')->default(4); // Max 4 membres
            $table->unsignedInteger('score')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();

            // Une école (code unique) a une seule équipe par domaine
            $table->unique(['join_code', 'field']);
            $table->unique(['name', 'field']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
