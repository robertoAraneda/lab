<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadHistoriesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::connection('mysqlGestion')->create('upload_histories', function (Blueprint $table) {
      $table->bigIncrements('id');
      $table->string('file_name');
      $table->integer('created_user_id')->nullable();
      $table->integer('updated_user_id')->nullable();
      $table->string('created_ip', 20)->nullable();
      $table->string('updated_ip', 20)->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::connection('mysqlGestion')->dropIfExists('upload_histories');
  }
}
