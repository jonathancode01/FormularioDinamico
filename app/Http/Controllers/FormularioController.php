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
        $campoFormularios = CampoFormulario::all();
        return view('welcome', compact('formularios'));
    }

    public function store(Request $request)
    {
        Log::info('Request data: ', $request->all());

        // Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'titulo' => 'required|string',
            'campos' => 'required|array',
            'campos.*.titulo' => 'required|string',
            'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            'campos.*.options' => 'nullable|array',
            'campos.*.options.*' => 'string',
        ]);

        Log::info('Validated data: ', $validatedData);

        // Criar o formulário principal
        $formulario = Formulario::create([
            'titulo' => $request->input('titulo'),
        ]);

        Log::info('Formulario created: ', $formulario->toArray());

        // Verificar se o formulário foi criado com sucesso
        if ($formulario) {
            // Criar os campos do formulário
            foreach ($request->input('campos') as $campo) {
                $novoCampo = CampoFormulario::create([
                    'formulario_id' => $formulario->id,
                    'titulo' => $campo['titulo'],
                    'tipo' => $campo['tipo'],
                ]);
                Log::info('Campo created: ', $novoCampo->toArray());

                // Criar as opções se o campo for do tipo select
                if ($campo['tipo'] === 'select' && isset($campo['options'])) {
                    foreach ($campo['options'] as $option) {
                        $newOption = SelectModel::create([
                            'campo_formulario_id' => $novoCampo->id,
                            'option_text' => $option,
                        ]);
                        Log::info('Option created: ', $newOption->toArray());
                    }
                }
            }

            // Redirecionar para a página de detalhes do formulário
            return response()->json(['message' => $formulario->id]);
        }

        // Em caso de falha ao criar o formulário, retornar uma resposta de erro
        return back()->withInput()->withErrors(['message' => 'Erro ao criar o formulário']);
    }

    public function show($id)
    {
        $formulario = Formulario::find($id);
        $campos = CampoFormulario::where('formulario_id', $id)->get();
        return view('formularios', compact('formulario', 'campos'));
    }
}
