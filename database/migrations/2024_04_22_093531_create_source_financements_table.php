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
        Schema::create('source_financements', function (Blueprint $table) {
            $table->id();
           
            $table->string('libelleLong');
            $table->unsignedBigInteger('ministere_id');
            $table->foreign('ministere_id')->references('id')->on('ministeres')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('source_financements');
    }
};
