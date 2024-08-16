<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Constraint\Constraint;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('respform', function (Blueprint $table) {
            // Adicionar a coluna de chave estrangeira
            $table->foreignId('formulario_id')->constrained('formularios')->onDelete('cascade');
            $table->foreignId('campo_id')->constrained('campos_formulario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('respform', function (Blueprint $table) {
            // Remover a chave estrangeira e a coluna
            $table->dropForeign(['formulario_id']);
            $table->dropColumn('formulario_id');

            $table->dropForeign(['campo_id']);
            $table->dropColumn('campo_id');
        });
    }
};
