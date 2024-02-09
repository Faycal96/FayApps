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
        Schema::table('demande_billets', function (Blueprint $table) {
            $table->string('classe_billet'); // Choisissez la colonne après laquelle vous souhaitez ajouter ce champ {
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_billets', function (Blueprint $table) {
            //
        });
    }
};
