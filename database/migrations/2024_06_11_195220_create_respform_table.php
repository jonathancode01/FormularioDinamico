<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respform', function (Blueprint $table) {
            $table->id();
            $table->string('resp');
            // Definindo a coluna 'resp' como chave estrangeira referenciando a coluna 'tipo' na tabela 'campos_formulario'
            $table->foreign('resp')->references('tipo')->on('campos_formulario')->onDelete('cascade');
            $table->string('resp_tipo');
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
        Schema::dropIfExists('respform');
    }
};
