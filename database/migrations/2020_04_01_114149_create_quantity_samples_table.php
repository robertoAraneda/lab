<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuantitySamplesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('quantity_samples', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('description');
      $table->unsignedBigInteger('state_id');
      $table->unsignedBigInteger('created_user_id');
      $table->unsignedBigInteger('updated_user_id')->nullable();
      $table->timestamps();

      $table->foreign('state_id')->references('id')->on('Laboratorio.states');
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
    Schema::dropIfExists('quantity_samples');
  }
}
