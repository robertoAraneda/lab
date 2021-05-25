<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('ubications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description', 255)->unique()->nullable();
            $table->unsignedBigInteger('created_user_id');
            $table->unsignedBigInteger('updated_user_id');
            $table->unsignedBigInteger('state_id');
            $table->string('created_user_ip', 20);
            $table->string('updated_user_ip', 20);
            $table->boolean('isActive')->default(true);
            $table->timestamps();
            $table->foreign('created_user_id')->references('id')->on('Laboratorio.users');
            $table->foreign('state_id')->references('id')->on('Laboratorio.states');
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
        Schema::connection('mysql2')->dropIfExists('ubications');
    }
}
