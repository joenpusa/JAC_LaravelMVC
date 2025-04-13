<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampoTipoToCertficadosTable extends Migration
{

    public function up()
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('tipo');
            $table->string('verificado', 3)->default('No')->after('tipo');
        });
    }


    public function down()
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->dropColumn('tipo');
            $table->dropColumn('verificado');
        });
    }
}
