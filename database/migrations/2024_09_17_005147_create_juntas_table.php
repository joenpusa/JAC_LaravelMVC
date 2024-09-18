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
            $table->string('resolucion');
            $table->date('fecha_resolucion')->nullable();;
            $table->date('fecha_eleccion')->nullable();;
            $table->unsignedBigInteger('presidente_id');
            $table->foreign('presidente_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('vicepresidente_id');
            $table->foreign('vicepresidente_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('secretario_id');
            $table->foreign('secretario_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('tesorero_id');
            $table->foreign('tesorero_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('fiscal_id');
            $table->foreign('fiscal_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('concil1_id');
            $table->foreign('concil1_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('concil2_id');
            $table->foreign('concil2_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('concil3_id');
            $table->foreign('concil3_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('delegado1_id');
            $table->foreign('delegado1_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('delegado2_id');
            $table->foreign('delegado2_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('delegado3_id');
            $table->foreign('delegado3_id') 
                  ->references('id')   
                  ->on('funcionarios');
            $table->unsignedBigInteger('comuna_id');
            $table->foreign('comuna_id') 
                  ->references('id')   
                  ->on('funcionarios');
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
