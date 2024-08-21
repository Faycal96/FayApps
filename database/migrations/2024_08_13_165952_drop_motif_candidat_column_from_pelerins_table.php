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
        Schema::table('pelerins', function (Blueprint $table) {
            $table->dropColumn('motif_candidat');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelerins', function (Blueprint $table) {
            $table->string('motif_candidat')->nullable();
        });
    }
};
