<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarpetasTable extends Migration
{
    public function up()
    {
        Schema::create('carpetas', function (Blueprint $table) {
            $table->id();
            $table->string('libro');
            $table->string('causal');
            $table->date('fecha');
            $table->integer('folios');
            $table->unsignedBigInteger('usuario_id');

            // Polimórfica
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');

            $table->timestamps();

            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('carpetas');
    }
}
