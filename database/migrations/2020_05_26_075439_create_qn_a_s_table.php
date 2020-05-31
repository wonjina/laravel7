<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnASTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qn_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('content');
            $table->string('respondent');
            $table->string('writer');
            $table->bigInteger('board_id')->unsigned()->index();
            $table->timestamps();
            $table->foreign('board_id')->references('id')->on('boards')->onCascade('delete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qn_a_s');
    }
}
