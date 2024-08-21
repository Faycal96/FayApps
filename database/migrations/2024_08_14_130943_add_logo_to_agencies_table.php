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
    Schema::table('agencies', function (Blueprint $table) {
        $table->string('logo')->nullable()->after('name'); // Ajout de la colonne photo
    });
}

public function down()
{
    Schema::table('agencies', function (Blueprint $table) {
        $table->dropColumn('logo'); // Retirer la colonne en cas de rollback
    });
}

};
