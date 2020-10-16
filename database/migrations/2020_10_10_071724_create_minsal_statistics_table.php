<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinsalStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlGestion')->create('minsal_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('id_testing_request');
            $table->string('sample');
            $table->string('result');
            $table->string('status');
            $table->string('professional_validator');
            $table->string('rejection_reason');
            $table->string('sending_institution');
            $table->string('processing_laboratory');
            $table->string('requesting_doctor');
            $table->string('patient_rut');
            $table->string('patient_name');
            $table->string('patient_gender');
            $table->string('patient_age');
            $table->string('patient_phone');
            $table->string('patient_email');
            $table->string('patient_comuna');
            $table->string('patient_address');
            $table->string('institution_region');
            $table->string('clasification');
            $table->dateTime('sampled_at');
            $table->dateTime('received_at');
            $table->dateTime('validated_at');
            $table->dateTime('notified_at');
            $table->dateTime('rejected_at');
            $table->dateTime('distributed_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlGestion')->dropIfExists('minsal_statistics');
    }
}
