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
            $table->decimal('total_verse', 10, 2)->nullable()->after('note');
            $table->decimal('reste_a_payer', 10, 2)->nullable()->after('total_verse');
        });
    }

    public function down()
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->dropColumn('total_verse');
            $table->dropColumn('reste_a_payer');
        });
    }
};
