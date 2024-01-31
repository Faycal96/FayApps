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
        Schema::create('demande_billets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->string('code_demande')->nullable();
            $table->string('lieuDepart')->nullable();
            $table->string('lieuArrive')->nullable();
            $table->date('dateDepart')->default(now);
            $table->date('dateArrive')->default(now);
            $table->string('numeroOrdreMission')->nullable();
            $table->integer('duree')->nullable();
            $table->integer('description')->nullable();
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
        Schema::dropIfExists('demande_billets');
    }
};
