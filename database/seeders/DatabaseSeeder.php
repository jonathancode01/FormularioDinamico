<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Inserir um formulário inicial
        $formularioId = DB::table('formularios')->insertGetId([
            'titulo' => 'Formulário de Exemplo',
        ]);

        // Verificar se foi obtido com sucesso o ID do formulário
        if ($formularioId) {
            // Inserir campos para o formulário
            $campoFormularioId = DB::table('campos_formulario')->insertGetId([
                'formulario_id' => $formularioId,
                'titulo' => 'Campo de Exemplo',
                'tipo' => 'select', // Suponha que o tipo seja 'select'
            ]);

            // Inserir opções para o campo de exemplo
            if ($campoFormularioId) {
                DB::table('select_options')->insert([
                    'campo_formulario_id' => $campoFormularioId,
                    'option_text' => 'Selecione',
                ]);
            } else {
                $this->command->info('Não foi possível obter o ID do campo_formulario.');
            }
        } else {
            $this->command->info('Não foi possível obter o ID do formulário.');
        }
    }
}
