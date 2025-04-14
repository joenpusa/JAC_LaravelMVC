<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComisionesTable extends Migration
{
    public function up()
    {
        Schema::create('comisiones', function (Blueprint $table) {
            $table->id();
            $table->string('nomcomision');
            $table->string('nomcomisionado');
            $table->string('owner_type'); // Junta o Asociacion
            $table->unsignedBigInteger('owner_id');
            $table->timestamps();

            // Opcional: índice para optimizar búsquedas polimórficas
            $table->index(['owner_type', 'owner_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('comisiones');
    }
}
