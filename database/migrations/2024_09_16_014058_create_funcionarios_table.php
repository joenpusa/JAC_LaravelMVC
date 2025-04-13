<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFuncionariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funcionarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('tipo_documento');
            $table->string('num_documento')->unique();
            $table->string('num_afiliacion')->nullable();
            $table->string('genero')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->string('profesion')->nullable();
            $table->string('grupo_etnico')->nullable();
            $table->boolean('discapacidad')->default(false);
            $table->string('name_anexo')->nullable();
            $table->string('key_anexo')->nullable();
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
        Schema::dropIfExists('funcionarios');
    }
}
