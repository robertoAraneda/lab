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
            $table->string('patient_rut')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('patient_gender')->nullable();
            $table->string('patient_age')->nullable();
            $table->string('patient_phone')->nullable();
            $table->string('patient_email')->nullable();
            $table->string('patient_address')->nullable();
            $table->string('sample')->nullable();
            $table->string('result')->nullable();
            $table->dateTime('sampled_at')->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('validated_at')->nullable();
            $table->string('requesting_institution_name')->nullable();
            $table->string('requesting_institution_region')->nullable();
            $table->string('processing_laboratory_name')->nullable();
            $table->string('processing_laboratory_region')->nullable();
           
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
