<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('typeCompte', function (Blueprint $table) {
            $table->id('compte_id');
            $table->unsignedBigInteger('utilisateur_id');
            $table->string('label');
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('utilisateur_id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('typeCompte');
    }
};
