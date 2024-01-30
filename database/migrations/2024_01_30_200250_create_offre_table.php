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
        Schema::create('offre', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('demande_id');
            $table->unsignedBigInteger('agence_id');
            $table->foreign('demande_id')->references('id')->on('demande_billet')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('agence_id')->references('id')->on('agence_acredite')->onDelete('cascade')->onUpdate('cascade');
            $table->double('prixBillet');
            $table->date('dateDepart')->nullable();
            $table->date('dateArrive')->nullable();
            $table->double('minPrix')->nullable();
            $table->double('maxPrix')->nullable();
            $table->string('description')->nullable();
            $table->date('dateDebutValidite');
            $table->date('dateFinValidite');
            $table->boolean('etat')->default(true);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offre');
    }
};
