<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimeResponseAnalyteDetailsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('time_response_analyte_details', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('analyte_id');
      $table->unsignedBigInteger('time_response_id_ambulatory');
      $table->unsignedBigInteger('time_response_id_hospitalized');
      $table->unsignedBigInteger('time_response_id_urgency');
      $table->unsignedBigInteger('time_response_id_external');
      $table->unsignedBigInteger('state_id');
      $table->unsignedBigInteger('created_user_id');
      $table->unsignedBigInteger('updated_user_id')->nullable();
      $table->timestamps();
      $table->foreign('state_id')->references('id')->on('Laboratorio.states');
      $table->foreign('time_response_id_ambulatory')->references('id')->on('Laboratorio.time_responses');
      $table->foreign('time_response_id_hospitalized')->references('id')->on('Laboratorio.time_responses');
      $table->foreign('time_response_id_urgency')->references('id')->on('Laboratorio.time_responses');
      $table->foreign('time_response_id_external')->references('id')->on('Laboratorio.time_responses');
      $table->foreign('created_user_id')->references('id')->on('Laboratorio.users');
      $table->foreign('updated_user_id')->references('id')->on('Laboratorio.users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('time_response_analyte_details');
  }
}
