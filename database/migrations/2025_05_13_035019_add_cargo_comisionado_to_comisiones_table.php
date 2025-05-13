<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoComisionadoToComisionesTable extends Migration
{
    public function up()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->string('doccomisionado', 30)->after('nomcomisionado');
        });
    }

    public function down()
    {
        Schema::table('comisiones', function (Blueprint $table) {
            $table->dropColumn('doccomisionado');
        });
    }
}
