<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResPersoneriaJuridicaToJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('juntas', function (Blueprint $table) {
            $table->string('res_personeria_juridica')->nullable()->after('fecha_resolucion');
            $table->date('fecha_res_personeria_juridica')->nullable()->after('res_personeria_juridica');
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
            $table->dropColumn([
                'res_personeria_juridica',
                'fecha_res_personeria_juridica',
            ]);
        });
    }
}
