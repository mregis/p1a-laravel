<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDtLeituraFieldToLeiturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('leituras', function (Blueprint $table) {
            $table->timestamp('dt_leitura')->nullable()->useCurrent();
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
            $table->dropIfExists('dt_leitura');
        });
    }
}
