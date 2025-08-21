<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taches', function (Blueprint $table) {
            $table->id('tache_id');
            $table->unsignedBigInteger('utilisateur_id');
            $table->unsignedBigInteger('project_id');
            $table->string('titreTache')->nullable();
            $table->text('description')->nullable();
            $table->enum('etat', ['en attente', 'en cours', 'terminé'])->default('en attente');
            $table->date('dateCreation');
            $table->date('dateFin')->nullable();
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('utilisateur_id')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('projet_id')->references('projet_id')->on('projet')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('taches');
    }
};
