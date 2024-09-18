<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixForeignKeyInJuntas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('juntas', function (Blueprint $table) {
            $table->dropForeign(['comuna_id']);

            $table->foreign('comuna_id')
              ->references('id')
              ->on('comunas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('juntas', function (Blueprint $table) {
            $table->foreign('comuna_id')
              ->references('id')
              ->on('funcionarios');
        });
    }
}
