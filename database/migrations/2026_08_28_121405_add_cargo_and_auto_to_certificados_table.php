<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCargoAndAutoToCertificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('cargo')->nullable()->after('nombre_dignatario');
            $table->string('auto_numero')->nullable()->after('cargo');
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
            $table->dropColumn(['cargo', 'auto_numero']);
        });
    }
}
