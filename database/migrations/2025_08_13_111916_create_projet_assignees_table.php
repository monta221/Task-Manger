<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projet_assignees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('utilisateur_id');
            $table->unsignedBigInteger('projet_id');
            $table->date('date_assigned')->nullable();
            $table->string('statut')->nullable();
            $table->timestamps();

            $table->foreign('utilisateur_id')->references('utilisateur_id')->on('utilisateurs')->onDelete('cascade');
            $table->foreign('projet_id')->references('projet_id')->on('projet')->onDelete('cascade');
            $table->unique(['utilisateur_id', 'projet_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projet_assignees');
    }
};
