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
            $table->string('type_vol')->nullable(); // Ajout de la colonne type_vol
            $table->string('lieu_naissance')->nullable(); // Ajout de la colonne lieu_naissance
        });
    }

    public function down()
    {
        Schema::table('pelerins', function (Blueprint $table) {
            $table->dropColumn('type_vol');
            $table->dropColumn('lieu_naissance');
        });
    }
};
