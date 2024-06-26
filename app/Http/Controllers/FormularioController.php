<?php

namespace App\Http\Controllers;

use App\Models\CampoFormulario;
use App\Models\SelectModel;
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
            'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            'campos.*.options' => 'array', // Validação para array de opções
            'campos.*.options.*' => 'string', // Validação para cada opção do select
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

                if($campo['tipo'] === 'select' && isset($campo['options'])){
                    foreach ($campo['options'] as $option) {
                        SelectModel::create([
                            'campo_formulario_id' => $campoFormulario->id,
                            'option_text' => $option,
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
