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
        Schema::create('pelerins', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('passeport');
            $table->string('prenom');
            $table->date('date_delivrance');
            $table->date('date_naissance');
            $table->date('date_expiration');
            $table->string('sexe');
            $table->string('nationalite');
            $table->string('telephone');
            $table->string('motif_candidat');
            $table->string('facilitateur');
            $table->string('statut_candidat')->default('Non payé');
            $table->string('ville_province');
            $table->text('note_observation')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelerins');
    }
};
