<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalytesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('analytes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->mediumText('observation');
            $table->unsignedBigInteger('loinc_id');
            $table->unsignedBigInteger('workarea_id');
            $table->unsignedBigInteger('label_id');
            $table->unsignedBigInteger('hca_laboratory_id');
            $table->unsignedBigInteger('infinity_labdate_test_id');
            $table->unsignedBigInteger('available_id');
            $table->unsignedBigInteger('vih_key_id');
            $table->unsignedBigInteger('time_process_id');
            $table->unsignedBigInteger('time_reception_id');
            $table->unsignedBigInteger('time_response_id');
            $table->unsignedBigInteger('medical_order_id');
            $table->unsignedBigInteger('fonasa_test_id');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id')->nullable();
            $table->timestamps();
            $table->foreign('created_user_id')->references('id')->on('users');
            $table->foreign('updated_user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('loinc_id')->references('id')->on('loincs');
            $table->foreign('workarea_id')->references('id')->on('workareas');
            $table->foreign('label_id')->references('id')->on('labels');
            $table->foreign('hca_laboratory_id')->references('id')->on('hca_laboratories');
            $table->foreign('infinity_labdate_test_id')->references('id')->on('infinity_labdate_tests');
            $table->foreign('available_id')->references('id')->on('availables');
            $table->foreign('vih_key_id')->references('id')->on('vih_keys');
            $table->foreign('time_process_id')->references('id')->on('time_processes');
            $table->foreign('time_reception_id')->references('id')->on('time_receptions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('analytes');
    }
}
