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
            $table->date('fecha_resolucion')->nullable();
            $table->date('fecha_eleccion')->nullable();
            $table->unsignedBigInteger('presidente_id');
            $table->unsignedBigInteger('vicepresidente_id');
            $table->unsignedBigInteger('secretario_id');
            $table->unsignedBigInteger('tesorero_id');
            $table->unsignedBigInteger('fiscal_id');
            $table->unsignedBigInteger('concil1_id')->nullable();
            $table->unsignedBigInteger('concil2_id')->nullable();
            $table->unsignedBigInteger('concil3_id')->nullable();
            $table->unsignedBigInteger('delegado1_id')->nullable();
            $table->unsignedBigInteger('delegado2_id')->nullable();
            $table->unsignedBigInteger('delegado3_id')->nullable();
            $table->unsignedBigInteger('comuna_id')->nullable();
            $table->string('nomanexo')->nullable();
            $table->string('keyanexo')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('presidente_id')->references('id')->on('funcionarios');
            $table->foreign('vicepresidente_id')->references('id')->on('funcionarios');
            $table->foreign('secretario_id')->references('id')->on('funcionarios');
            $table->foreign('tesorero_id')->references('id')->on('funcionarios');
            $table->foreign('fiscal_id')->references('id')->on('funcionarios');
            $table->foreign('concil1_id')->references('id')->on('funcionarios');
            $table->foreign('concil2_id')->references('id')->on('funcionarios');
            $table->foreign('concil3_id')->references('id')->on('funcionarios');
            $table->foreign('delegado1_id')->references('id')->on('funcionarios');
            $table->foreign('delegado2_id')->references('id')->on('funcionarios');
            $table->foreign('delegado3_id')->references('id')->on('funcionarios');
            $table->foreign('comuna_id')->references('id')->on('comunas');
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
