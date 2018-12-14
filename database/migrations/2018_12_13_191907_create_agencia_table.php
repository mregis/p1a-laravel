<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencia', function (Blueprint $table) {
            $table->increments('id');
            $table->string("codigo", 4)->unique('IX_AGENCIA_CODIGO');
            $table->string("nome", 100);
            $table->string("endereco", 100);
            $table->string("bairro", 100);
            $table->string("cep", 9);
            $table->string("cidade", 100);
            $table->string("uf", 2);
            $table->string("cd", 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencia');
    }
}
