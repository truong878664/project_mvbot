<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robot_status', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial');
            $table->string('mode');
            $table->string('volt_pin');
            $table->string('percent_pin');
            $table->string('radar1');
            $table->string('radar2');
            $table->string('camera1');
            $table->string('camera2');
            $table->string('I');
            $table->string('charging');
            $table->string('cell');
            $table->string('option');
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
        Schema::dropIfExists('robot_status');
    }
};
