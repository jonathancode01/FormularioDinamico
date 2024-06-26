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
        Schema::create('selects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campo_formulario_id');
            $table->string('option_text');
            $table->foreign('campo_formulario_id')->references('id')->on('campos_formulario')->onDelete('cascade');
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
        Schema::dropIfExists('selects');
    }
};
