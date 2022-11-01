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
        //
        Schema::table('table_wifi', function (Blueprint $table) {
            $table
            ->foreign('robot_id')
            ->references('id')
            ->on('robot_status');
        });
    }

    /**
     * Reverse the migrations. 
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('table_wifi', function (Blueprint $table) {
            $table->dropForeign('table_wifi_robot_id_foreign');
        });
    }
};
