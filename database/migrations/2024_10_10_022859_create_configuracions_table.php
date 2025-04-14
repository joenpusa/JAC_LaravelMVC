<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfiguracionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('configuracions', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_app');
            $table->string('nom_entidad')->nullable();
            $table->string('direccion');
            $table->string('horario');
            $table->string('logo')->nullable();
            $table->string('telefono');
            $table->string('email');
            $table->string('nombre_secretario')->nullable();
            $table->string('secretaria')->nullable();
            $table->string('nomfirma')->nullable();
            $table->string('keyfirma')->nullable();
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
        Schema::dropIfExists('configuracions');
    }
}
