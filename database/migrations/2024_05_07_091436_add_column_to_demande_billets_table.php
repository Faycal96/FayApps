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
            $table->integer('dureevoyage')->nullable();
            $table->integer('nbrescale')->nullable()->default(0);
            $table->string('type_agrement')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('demande_billets', function (Blueprint $table) {
            $table->dropColumn('dureevoyage');
            $table->dropColumn('nbrescale');
            $table->dropColumn('type_agrement');
        });
    }
};
