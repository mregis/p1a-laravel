<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeiturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leituras', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('lote_id');
            $table->integer('user_id');
            $table->integer('unidade_id');
            $table->string('capalote')->index('IX_LEITURAS_CAPALOTE');
            $table->boolean('presente');
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('lote_id')->references('id')->on('lotes');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leituras');
    }
}
