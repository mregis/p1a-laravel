<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToLeiturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leituras', function (Blueprint $table) {
            $table->string('lacre')->nullable()->index('IX_LEITURAS_LACRE');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leituras', function (Blueprint $table) {
            $table->dropIfExists('lacre');
        });
    }
}
