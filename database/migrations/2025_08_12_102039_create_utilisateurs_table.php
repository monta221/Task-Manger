<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id('utilisateur_id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('type', ['admin','dev','chefprojet','profil'])->default('profil');
            $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
};
