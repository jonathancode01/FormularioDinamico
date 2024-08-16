<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampoFormulario;
use App\Models\Formulario;
use App\Models\RespFormulario;

class CamposController extends Controller
{

    public function index()
    {

    }

    public function store(Request $request, $id)
    {
        $formularioId = $id;

        // Validação dos dados recebidos do formulário
        $request->validate([
            'campos.*.resp' => 'required|string',
            'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            'campos.*.campo_id' => 'required|exists:campos_formulario,id', // Adiciona validação para campo_id
        ]);

        foreach ($request->input('campos') as $campo) {
            RespFormulario::create([
                'resp' => $campo['resp'],
                'resp_tipo' => $campo['tipo'],
                'formulario_id' => $formularioId,
                'campo_id' => $campo['campo_id'], // Inclui o campo_id aqui
            ]);
        }

        return redirect('/')->with('success', 'Respostas enviadas com sucesso!');
    }

    public function show($id)
    {
        $formulario = Formulario::find($id);
        $respostas = RespFormulario::where('formulario_id', $id)->get(); // Corrigido aqui
        $campos = CampoFormulario::where('formulario_id', $id)->get();

        return view('respostas', compact('formulario', 'campos', 'respostas'));
    }

    public function search(Request $request)
    {
        dd($request->all());
        $search = $request->input('search');

        // Realiza a busca pelo título específico
        $formulario = Formulario::where('titulo', 'like', '%' . $search . '%')->first();

        if (!$formulario) {
            return response()->json(['message' => 'Nenhum formulário encontrado']);
        }

        return response()->json([
            'id' => $formulario->id,
            'titulo' => $formulario->titulo,
            // Adicione outros campos do formulário se necessário
        ]);
    }

}
