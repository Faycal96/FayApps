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
            $table->string('photo')->nullable()->after('telephone'); // Ajout de la colonne photo
        });
    }
    
    public function down()
    {
        Schema::table('pelerins', function (Blueprint $table) {
            $table->dropColumn('photo'); // Retirer la colonne en cas de rollback
        });
    }
};
