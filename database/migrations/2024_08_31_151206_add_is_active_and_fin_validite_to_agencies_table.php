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
            $table->boolean('is_active')->default(true);
            $table->date('fin_validite')->nullable();
        });
    }

    public function down()
    {
        Schema::table('agencies', function (Blueprint $table) {
            $table->dropColumn('is_active');
            $table->dropColumn('fin_validite');
        });
    }
};
