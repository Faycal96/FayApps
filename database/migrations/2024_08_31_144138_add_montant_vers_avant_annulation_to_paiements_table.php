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
        Schema::table('paiements', function (Blueprint $table) {
            $table->decimal('montant_vers_avant_annulation', 10, 2)->nullable()->after('montant');
        });
    }

    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn('montant_vers_avant_annulation');
        });
    }
};
