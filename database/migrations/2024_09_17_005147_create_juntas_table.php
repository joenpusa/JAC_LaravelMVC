<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juntas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('resolucion')->nullable();
            $table->string('personeria')->nullable();
            $table->date('fecha_resolucion')->nullable();;
            $table->date('fecha_eleccion')->nullable();;
            $table->unsignedBigInteger('presidente_id');
            $table->foreign('presidente_id')
                  ->references('id')
                  ->on('funcionarios');
            $table->unsignedBigInteger('vicepresidente_id')->nullable();
            $table->foreign('vicepresidente_id')
                  ->references('id')
                  ->on('funcionarios');
            $table->unsignedBigInteger('secretario_id')->nullable();
            $table->foreign('secretario_id')
                  ->references('id')
                  ->on('funcionarios');
            $table->unsignedBigInteger('tesorero_id')->nullable();
            $table->foreign('tesorero_id')
                  ->references('id')
                  ->on('funcionarios');
            $table->unsignedBigInteger('fiscal_id')->nullable();
            $table->foreign('fiscal_id')
                  ->references('id')
                  ->on('funcionarios');
            $table->unsignedBigInteger('comuna_id')->nullable();
            $table->foreign('comuna_id')
                  ->references('id')
                  ->on('comunas');
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->foreign('municipio_id')
                  ->references('id')
                  ->on('municipios');
            $table->string('nomanexo')->nullable();
            $table->string('keyanexo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('juntas');
    }
}
