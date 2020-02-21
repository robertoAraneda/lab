<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoincsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loincs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('loinc_num');
            $table->text('component')->nullable();
            $table->string('property')->nullable();
            $table->string('system_')->nullable();
            $table->string('scale_typ')->nullable();
            $table->string('method_typ')->nullable();
            $table->string('class')->nullable();
            $table->string('status')->nullable();
            $table->text('relatednames2')->nullable();
            $table->string('shortname')->nullable();
            $table->string('order_obs')->nullable();
            $table->string('example_units')->nullable();
            $table->string('long_common_name');
            $table->string('unitsandrange')->nullable();
            $table->string('example_ucum_units')->nullable();
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
        Schema::dropIfExists('loincs');
    }
}
