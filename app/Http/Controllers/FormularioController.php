<?php

namespace App\Http\Controllers;

use App\Models\OpcoesForm;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Formulario;
use App\Models\CampoFormulario;



class FormularioController extends Controller {

    public function index() {
        $formularios = Formulario::all();
        return view('welcome', compact('formularios'));
    }

    public function store(Request $request) {
        // dd($request->all());
        $request->validate([
            'titulo' => 'required|string',
            'campos.*.titulo' => 'required|string',
            'campos.*.tipo' => 'required|string|in:texto,textoarea,multiplo',
            'campos.*.opcoes' => 'nullable|array', // Validação opcional para as opções, se necessário
            'campos.*.opcoes.*' => 'string', // Validação opcional para as opções, se necessário

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

                // Crie o campo do formulário
                $campoFormulario = CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'] ?? '',
                    'tipo' => $campo['tipo'] ?? '',
                ]);

                // Se houver opções, salve-as na tabela 'opcoes_form'
                if (in_array($campo['tipo'], ['checkbox']) && isset($campo['opcoes'])) {
                    foreach ($campo['opcoes'] as $opcao) {
                        OpcoesForm::create([
                            'element_id' => $campoFormulario->id, // Utilize o ID do campo criado
                            'checkbox' => $opcao
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
        return view('formularios', compact('formulario'));
    }

}
