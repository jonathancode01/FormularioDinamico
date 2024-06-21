<?php

namespace App\Http\Controllers;

use App\Models\CampoFormulario;
use App\Models\OpcoesForm;
use App\Models\Formulario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FormularioController extends Controller
{
    public function index()
    {
        $formularios = Formulario::all();
        return view('welcome', compact('formularios'));
    }

    public function store(Request $request)
    {
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
                throw new \Exception('Formulário não encontrado');
            }

            foreach ($request->input('campos', []) as $campo) {
                Log::info('Processing campo: ', $campo);

                // Crie o campo do formulário
                $campoFormulario = CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'] ?? '',
                    'tipo' => $campo['tipo'] ?? '',
                ]);

                // Se o campo for do tipo "multiplo" (checkbox), salve as opções na tabela OpcoesForm
                if ($campo['tipo'] === 'multiplo' && isset($campo['opcoes'])) {
                    foreach ($campo['opcoes'] as $opcao) {
                        OpcoesForm::create([
                            'element_id' => $campoFormulario->id,
                            'checkbox' => $opcao
                        ]);
                    }
                }
            }

            Log::info('Formulário criado com sucesso!');
            return response()->json(['message' => $formulario->id, 'formulario' => $formulario], 200);
        } catch (\Exception $e) {
            Log::error('Erro ao salvar o formulário: ', ['error' => $e->getMessage()]);
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $formulario = Formulario::with('campos.opcoes')->find($id);
        if (!$formulario) {
            return response()->json(['message' => 'Formulário não encontrado'], 404);
        }
        return view('formularios', compact('formulario'));
    }
}
