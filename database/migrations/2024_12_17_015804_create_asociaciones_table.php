<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsociacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asociaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('resolucion');
            $table->string('personeria')->nullable();
            $table->date('fecha_resolucion')->nullable();
            $table->date('fecha_eleccion')->nullable();
            $table->unsignedBigInteger('presidente_id');
            $table->unsignedBigInteger('vicepresidente_id')->nullable();
            $table->unsignedBigInteger('secretario_id')->nullable();
            $table->unsignedBigInteger('tesorero_id')->nullable();
            $table->unsignedBigInteger('fiscal_id')->nullable();
            $table->unsignedBigInteger('comuna_id')->nullable();
            $table->unsignedBigInteger('municipio_id')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('presidente_id')->references('id')->on('funcionarios');
            $table->foreign('vicepresidente_id')->references('id')->on('funcionarios');
            $table->foreign('secretario_id')->references('id')->on('funcionarios');
            $table->foreign('tesorero_id')->references('id')->on('funcionarios');
            $table->foreign('fiscal_id')->references('id')->on('funcionarios');
            $table->foreign('comuna_id')->references('id')->on('comunas');
            $table->foreign('municipio_id')->references('id')->on('municipios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asociaciones');
    }
}
