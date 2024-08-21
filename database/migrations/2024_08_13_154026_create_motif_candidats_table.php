<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('motif_candidats', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->decimal('montant', 10, 2); // Montant de l'édition
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motif_candidats');
    }
};
