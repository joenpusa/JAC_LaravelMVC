<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFechaNacimientoToFuncionariosTable extends Migration
{
    public function up()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->date('fecha_nacimiento')->nullable()->after('genero');
        });
    }

    public function down()
    {
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn('fecha_nacimiento');
        });
    }
}
