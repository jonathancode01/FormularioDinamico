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
        Schema::create('campos_formulario', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('formulario_id')->constrained('respform')->onDelete('cascade');
            $table->foreignId('formulario_id')->references('id')->on('formularios')->onDelete('cascade');

            $table->string('titulo');
            $table->string('tipo')->unique();
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
        Schema::dropIfExists('campos_formulario');
    }
};
