<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnalyticsReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytics_report', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('filename');
            $table->string('hash');
            $table->string('state');
            $table->text('args');
            $table->timestamps();
            $table->softDeletes();
            $table->unique('hash');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytics_report');
    }
}
