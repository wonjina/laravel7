<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeQnasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qn_a_s', function (Blueprint $table) {
            $table->dropForeign('qn_a_s_board_id_foreign');
            $table->dropColumn('writer');
            $table->foreign('board_id')->references('id')->on('boards')->onDelete('cascade')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qn_a_s', function (Blueprint $table) {
            $table->foreign('board_id')->references('id')->on('boards')->onCascade('delete')->change();
            $table->string('writer');
        });
    }
}
