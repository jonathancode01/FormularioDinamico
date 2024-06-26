<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Verificar se a tabela respform já existe
        if (Schema::hasTable('respform')) {
            // Inserir valor em respform
            DB::table('respform')->insert([
                'resp' => 'Texto de exemplo',
                'resp_tipo' => 'textoarea'
            ]);
        }

        // Verificar se a tabela campos_formulario já existe
        if (Schema::hasTable('campos_formulario')) {
            // Inserir valor em campos_formulario
            DB::table('campos_formulario')->insert([
                'formulario_id' => 1,
                'titulo' => 'Campo de Exemplo',
                'tipo' => 'textoarea'
            ]);
        }
    }
}
