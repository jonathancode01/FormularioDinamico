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
            $table->unsignedBigInteger('ID_RESP');
            $table->foreign('ID_RESP')->references('id')->on('campos_formulario')->onDelete('cascade');
            $table->string('texto');
            $table->string('textoarea');
            $table->string('multiplo');
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
