<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresidencyConsolidatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysqlGestion')->create('presidency_consolidates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->dateTime('current_date')->nullable();
            $table->dateTime('initial_date')->nullable();
            $table->dateTime('last_date')->nullable();
            $table->integer('current_stock')->nullable();
            $table->integer('received')->nullable();
            $table->integer('notified')->nullable();
            $table->integer('final_stock')->nullable();
            $table->integer('positive')->nullable();
            $table->integer('sum_notified')->nullable();
            $table->integer('sum_positive')->nullable();
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
        Schema::connection('mysqlGestion')->dropIfExists('presidency_consolidates');
    }
}
