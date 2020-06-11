<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovementProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::connection('mysql2')->create('movement_products', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->unsignedBigInteger('product_id');
      $table->integer('quantity');
      $table->string('movement');
      $table->unsignedBigInteger('user_id');
      $table->string('user_ip', 45);
      $table->timestamps();

      $table->foreign('user_id')->references('id')->on('Laboratorio.users');
      $table->foreign('product_id')->references('id')->on('bodega.products');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('movement_products');
  }
}
