<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('docs', function (Blueprint $table) {
            $table->string('from_agency', 4)->index('IX_DOCS_FROMAGENCY');
            $table->string('to_agency', 4)->index('IX_DOCS_TOAGENCY');
            $table->integer('qt_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('docs', function (Blueprint $table) {
            $table->dropIndex(['IX_DOCS_FROMAGENCY','IX_DOCS_TOAGENCY']); // Drops indexes
            $table->dropColumn(['from_agency','to_agency', 'qt_item']);
        });
    }
}
