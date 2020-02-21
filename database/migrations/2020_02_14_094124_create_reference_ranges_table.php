<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceRangesTable extends Migration
{

    public function up()
    {
        Schema::create('reference_ranges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('test_id');
            $table->unsignedBigInteger('gender_id');
            $table->unsignedBigInteger('age_unit_id');
            $table->integer('age_start');
            $table->integer('age_end');
            $table->float('normal_minimun');
            $table->float('normal_maximum');
            $table->float('critical_minimum');
            $table->float('critical_maximum');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->timestamps();
            $table->foreign('test_id')->references('id')->on('tests');
            $table->foreign('gender_id')->references('id')->on('genders');
            $table->foreign('age_unit_id')->references('id')->on('age_units');
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
        });
    }


    public function down()
    {
        Schema::dropIfExists('reference_ranges');
    }
}
