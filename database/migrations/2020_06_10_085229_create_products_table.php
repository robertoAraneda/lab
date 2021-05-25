<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::connection('mysql2')->create('products', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('code', 50)->unique();
      $table->string('description', 255)->unique();
      $table->integer('price');
      $table->unsignedBigInteger('category_id');
      $table->unsignedBigInteger('ubication_id');
      $table->unsignedBigInteger('created_user_id');
      $table->unsignedBigInteger('updated_user_id');
      $table->string('created_user_ip', 20)->nullable();
      $table->string('updated_user_ip', 20)->nullable();
      $table->boolean('isActive')->default(true);
      $table->timestamps();
      $table->foreign('category_id')->references('id')->on('categories');
      $table->foreign('ubication_id')->references('id')->on('ubitations');
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
    Schema::connection('mysql2')->dropIfExists('products');
  }
}
