<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToAutosTable extends Migration
{
    public function up()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->string('tipo', 20)->nullable()->after('numero');
        });
    }

    public function down()
    {
        Schema::table('autos', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}

