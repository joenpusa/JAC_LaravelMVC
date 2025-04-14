<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutosTable extends Migration
{
    public function up()
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('numero', 5); // 5 caracteres para el número
            $table->string('keyarchivo')->nullable(); // ruta o key del archivo
            $table->unsignedBigInteger('usuario_id');

            // Polimórfica
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');

            $table->timestamps();

            // FK al usuario
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('autos');
    }
}
