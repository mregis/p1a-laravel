<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDocShistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('docs_history', function (Blueprint $table) {
            $table->integer('unidade_id')->nullable();
            $table->foreign('unidade_id')->references('id')->on('unidades');
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
        Schema::table('docs_history', function (Blueprint $table) {
            $table->dropIfExists('dt_leitura');
            $table->dropForeign(['unidade_id']);
            $table->dropIfExists('unidade_id');
        });
    }
}
