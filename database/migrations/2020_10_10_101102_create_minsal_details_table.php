<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMinsalDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlGestion')->create('minsal_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('patient_rut');
            $table->string('patient_name');
            $table->string('patient_gender');
            $table->string('patient_age');
            $table->string('patient_phone');
            $table->string('patient_email');
            $table->string('patient_address');
            $table->string('sample');
            $table->string('result');
            $table->dateTime('sampled_at');
            $table->dateTime('received_at');
            $table->dateTime('validated_at');
            $table->string('requesting_institution_name');
            $table->string('requesting_institution_region');
            $table->string('processing_laboratory_name');
            $table->string('processing_laboratory_region');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysqlGestion')->dropIfExists('minsal_details');
    }
}
