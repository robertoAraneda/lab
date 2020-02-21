<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyteLabelsTable extends Migration
{

    public function up()
    {
        Schema::create('analyte_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('label_id');
            $table->unsignedBigInteger('analyte_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->timestamps();
            $table->foreign('label_id')->references('id')->on('labels');
            $table->foreign('analyte_id')->references('id')->on('analytes');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('analyte_labels');
    }
}
