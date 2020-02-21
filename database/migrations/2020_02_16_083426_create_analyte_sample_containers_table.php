<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyteSampleContainersTable extends Migration
{

    public function up()
    {
        Schema::create('analyte_sample_containers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('main_analyte_id');
            $table->unsignedBigInteger('analyte_id');
            $table->unsignedBigInteger('sample_collection_method_id');
            $table->unsignedBigInteger('container_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->timestamps();
            $table->foreign('main_analyte_id')->references('id')->on('main_analytes');
            $table->foreign('analyte_id')->references('id')->on('analytes');
            $table->foreign('sample_collection_method_id')->references('id')->on('sample_collection_methods');
            $table->foreign('container_id')->references('id')->on('containers');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }

    public function down()
    {
        Schema::dropIfExists('analyte_sample_containers');
    }
}
