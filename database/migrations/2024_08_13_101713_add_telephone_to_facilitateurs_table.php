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
        Schema::table('facilitateurs', function (Blueprint $table) {
            $table->string('telephone')->nullable(); // Add telephone column
        });
    }
    
    public function down()
    {
        Schema::table('facilitateurs', function (Blueprint $table) {
            $table->dropColumn('telephone');
        });
    }
};
