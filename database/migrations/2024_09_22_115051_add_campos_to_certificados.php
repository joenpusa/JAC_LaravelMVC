<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCamposToCertificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('resolucion');
            $table->date('fecha_resolucion');
            $table->date('fecha_eleccion');
            $table->string('documento_dignario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->dropColumn(
                ['resolucion',
                 'fecha_resolucion',
                 'fecha_eleccion',
                 'documento_dignario'
                ]);
        });
    }
}
