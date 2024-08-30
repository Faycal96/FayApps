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
        $table->string('motif_annulation')->nullable()->after('statut_paiement');
    });
}

public function down()
{
    Schema::table('paiements', function (Blueprint $table) {
        $table->dropColumn('motif_annulation');
    });
}
};
