<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSampleCollectionMethodsTable extends Migration
{

    public function up()
    {
        Schema::create('sample_collection_methods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sample_id');
            $table->unsignedBigInteger('collection_method_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->timestamps();
            $table->foreign('sample_id')->references('id')->on('samples');
            $table->foreign('collection_method_id')->references('id')->on('collection_methods');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sample_collection_methods');
    }
}
