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
        Schema::create('table_wifi', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('name')->unique();
            $table->string('password');
            $table->integer('robot_id')->unsigned();
            $table->string('ip_node');
            $table->string('ip_master');
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
        Schema::dropIfExists('table_wifi');
    }
};
