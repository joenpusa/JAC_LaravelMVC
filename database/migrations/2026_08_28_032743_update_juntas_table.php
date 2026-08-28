<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('juntas', function (Blueprint $table) {
            // Nuevos campos
            $table->string('auto_numero')->nullable()->after('municipio_id');
            $table->string('tipo_auto')->nullable()->after('auto_numero');
            $table->date('fecha_auto')->nullable()->after('tipo_auto');
            $table->date('fecha_inicio_periodo')->nullable()->after('fecha_eleccion');
            $table->date('fecha_final_periodo')->nullable()->after('fecha_inicio_periodo');
            $table->string('tipo_oac')->nullable()->after('personeria');
            $table->string('zona')->nullable()->after('tipo_oac');
        });

        // Modificar campos existentes a nullable usando sentencias DB para evitar requerir doctrine/dbal
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY resolucion VARCHAR(255) NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY personeria VARCHAR(255) NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY presidente_id BIGINT UNSIGNED NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Revertir campos existentes
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY resolucion VARCHAR(255) NOT NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY personeria VARCHAR(255) NOT NULL;');
        \Illuminate\Support\Facades\DB::statement('ALTER TABLE juntas MODIFY presidente_id BIGINT UNSIGNED NOT NULL;');

        Schema::table('juntas', function (Blueprint $table) {
            // Eliminar campos nuevos
            $table->dropColumn([
                'auto_numero',
                'tipo_auto',
                'fecha_auto',
                'fecha_inicio_periodo',
                'fecha_final_periodo',
                'tipo_oac',
                'zona'
            ]);
        });
    }
}

