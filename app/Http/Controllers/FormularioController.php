<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\CampoFormulario;
use App\Models\OpcaoForm;

class FormularioController extends Controller {

    public function index() {
        $formularios = Formulario::all();
        return view('welcome', compact('formularios'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'titulo' => 'required|string',
        ]);

        try {
            Log::info('Request received: ', $request->all());

            // Primeiro, crie o formulário sem o campo 'form_id'
            $formulario = Formulario::create([
                'titulo' => $request->input('titulo')
            ]);

            if (!$formulario) {
                throw new \Exception('Formulario não encontrado');
            }

            foreach ($request->input('campos', []) as $campo) {
                Log::info('Processing campo: ', $campo);
                $opcoes = $campo['tipo'] == 'multiplo' && isset($campo['opcoes']) ? $campo['opcoes'] : null;

                // Crie o campo do formulário
                $campoFormulario = CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'] ?? '',
                    'tipo' => $campo['tipo'] ?? '',
                ]);

                // Se houver opções, salve-as na tabela 'opcoes_form'
                if ($opcoes) {
                    foreach ($opcoes as $opcao) {
                        OpcaoForm::create([
                            'opcaoForm_id' => $campoFormulario->id, // Utilize o ID do campo criado
                            'opcao' => $opcao
                        ]);
                    }
                }
            }

            Log::info('Formulario criado com sucesso!');
            return response()->json(['message' => $formulario->id, 'formulario' => $formulario], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar o formulario: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id) {
        $formulario = Formulario::with('campos.opcoes')->find($id);
        if (!$formulario) {
            return response()->json(['message' => 'Formulario não encontrado'], 404);
        }
        return response()->json($formulario, 200);
    }
}
