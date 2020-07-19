<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_field_values', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
            $table->bigInteger('field_id')->unsigned();
            $table->foreign('field_id')->references('id')->on('pdf_fields')->onCascade('delete');
            $table->bigInteger('pdf_id')->unsigned();
            $table->foreign('pdf_id')->references('id')->on('pdfs');
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
        Schema::dropIfExists('pdf_field_values');
    }
}
