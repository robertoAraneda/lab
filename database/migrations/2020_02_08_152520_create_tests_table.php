<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->unsignedBigInteger('infinity_test_id');
            $table->unsignedBigInteger('fonasa_test_id');
            $table->unsignedBigInteger('loinc_id');
            $table->unsignedBigInteger('method_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->timestamps();
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('infinity_test_id')->references('id')->on('infinity_tests');
            $table->foreign('fonasa_test_id')->references('id')->on('fonasa_tests');
            $table->foreign('loinc_id')->references('id')->on('loincs');
            $table->foreign('method_id')->references('id')->on('methods');
            $table->foreign('unit_id')->references('id')->on('units');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
