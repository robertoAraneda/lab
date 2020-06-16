<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnalyteSampleConditionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('analyte_sample_conditions', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('analyte_id');
      $table->unsignedBigInteger('sample_condition_id');
      $table->unsignedBigInteger('created_user_id');
      $table->integer('order');
      $table->timestamps();

      $table->foreign('created_user_id')->references('id')->on('Laboratorio.users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('analyte_sample_conditions');
  }
}
