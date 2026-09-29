<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateAsociacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asociaciones', function (Blueprint $table) {
            $table->string('res_personeria_juridica')->nullable()->after('fecha_resolucion');
            $table->date('fecha_res_personeria_juridica')->nullable()->after('res_personeria_juridica');
            $table->date('fecha_inicio_periodo')->nullable()->after('fecha_eleccion');
            $table->date('fecha_final_periodo')->nullable()->after('fecha_inicio_periodo');
            $table->string('auto_numero')->nullable()->after('municipio_id');
            $table->string('tipo_auto')->nullable()->after('auto_numero');
            $table->date('fecha_auto')->nullable()->after('tipo_auto');
            $table->string('tipo_oac')->nullable()->after('personeria');
            $table->string('zona')->nullable()->after('tipo_oac');
            $table->string('nomanexo')->nullable()->after('zona');
            $table->string('keyanexo')->nullable()->after('nomanexo');
        });

        // Modificar campos existentes a nullable usando sentencias DB
        DB::statement('ALTER TABLE asociaciones MODIFY resolucion VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE asociaciones MODIFY personeria VARCHAR(255) NULL;');
        DB::statement('ALTER TABLE asociaciones MODIFY presidente_id BIGINT UNSIGNED NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE asociaciones MODIFY resolucion VARCHAR(255) NOT NULL;');
        DB::statement('ALTER TABLE asociaciones MODIFY presidente_id BIGINT UNSIGNED NOT NULL;');

        Schema::table('asociaciones', function (Blueprint $table) {
            $table->dropColumn([
                'res_personeria_juridica',
                'fecha_res_personeria_juridica',
                'fecha_inicio_periodo',
                'fecha_final_periodo',
                'auto_numero',
                'tipo_auto',
                'fecha_auto',
                'tipo_oac',
                'zona',
                'nomanexo',
                'keyanexo',
            ]);
        });
    }
}
