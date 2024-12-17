<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDocumentosForPolymorphic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('documentos', function (Blueprint $table) {
            // 1. Agregar columnas para la relación polimórfica
            $table->unsignedBigInteger('documentable_id')->nullable();
            $table->string('documentable_type')->nullable();

            // 2. Actualizar los datos existentes para asignar el tipo 'Junta'
            // Esto es una operación manual que debe realizarse a nivel de base de datos.
        });

        // 3. Migrar los datos existentes de junta_id a documentable_id
        DB::statement("
            UPDATE documentos
            SET documentable_id = junta_id,
                documentable_type = 'App\\\\Models\\\\Junta'
        ");

        Schema::table('documentos', function (Blueprint $table) {
            // 4. Eliminar la columna junta_id y su clave foránea
            $table->dropForeign(['junta_id']);
            $table->dropColumn('junta_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('documentos', function (Blueprint $table) {
            // 1. Volver a agregar la columna junta_id
            $table->unsignedBigInteger('junta_id')->nullable();

            // 2. Restaurar la clave foránea
            $table->foreign('junta_id')->references('id')->on('juntas');

            // 3. Migrar los datos de documentable_id a junta_id (solo si el tipo es Junta)
        });

        // Migrar datos de vuelta
        DB::statement("
            UPDATE documentos
            SET junta_id = documentable_id
            WHERE documentable_type = 'App\\\\Models\\\\Junta'
        ");

        Schema::table('documentos', function (Blueprint $table) {
            // 4. Eliminar las columnas polimórficas
            $table->dropColumn(['documentable_id', 'documentable_type']);
        });
    }
}
