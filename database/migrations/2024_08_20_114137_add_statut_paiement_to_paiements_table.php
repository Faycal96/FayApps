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
            $table->enum('statut_paiement', ['En cours', 'Annulé', 'Payé'])->default('En cours');
        });
    }
    
    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn('statut_paiement');
        });
    }
    
};
