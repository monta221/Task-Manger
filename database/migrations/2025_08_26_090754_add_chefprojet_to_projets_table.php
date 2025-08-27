<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->unsignedBigInteger('chefprojet_id')->nullable()->after('projet_id');
            $table->foreign('chefprojet_id')
                  ->references('utilisateur_id')
                  ->on('utilisateurs')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['chefprojet_id']);
            $table->dropColumn('chefprojet_id');
        });
    }
};
