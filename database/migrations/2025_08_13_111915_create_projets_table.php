<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projets', function (Blueprint $table) {
            $table->id('projet_id');
            $table->string('titreProjet');
            $table->text('description')->nullable();
            $table->date('dateDebut');
            $table->date('dateFin')->nullable();
            $table->integer('note')->nullable();
            $table->string('etat')->default('en attente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projets');
    }
};
