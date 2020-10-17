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
            $table->bigInteger('id_testing_request')->nullable();
            $table->string('sample')->nullable();
            $table->string('result')->nullable();
            $table->string('status')->nullable();
            $table->string('professional_validator')->nullable();
            $table->string('rejection_reason')->nullable();
            $table->string('sending_institution')->nullable();
            $table->string('processing_laboratory')->nullable();
            $table->string('requesting_doctor')->nullable();
            $table->string('patient_rut')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_phone')->nullable();
            $table->string('patient_email')->nullable();
            $table->string('patient_comuna')->nullable();
            $table->string('patient_address')->nullable();
            $table->string('institution_region')->nullable();
            $table->string('clasification')->nullable();
            $table->dateTime('sampled_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('validated_at')->nullable();
            $table->dateTime('notified_at')->nullable();
            $table->dateTime('rejected_at')->nullable();
            $table->dateTime('distributed_at')->nullable();
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
