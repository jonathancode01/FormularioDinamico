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

        $formularioId = $id; // Assumindo que o ID do formulário é enviado no request

        // Validação dos dados recebidos do formulário
        $request->validate([
            'campos.*.resp' => 'required|string',
            'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
        ]);

        foreach ($request->input('campos') as $campo) {
            $request->validate([
                'campos.*.resp' => 'required|string',
                'campos.*.tipo' => 'required|string|in:texto,textoarea,select',
            ]);

            RespFormulario::create([
                'resp' => $campo['resp'],
                'resp_tipo' => $campo['tipo'],
                'formulario_id' => $formularioId, // Assumindo que você quer relacionar a resposta com um formulário específico
            ]);
        }

        return redirect('/')->with('success', 'Respostas enviadas com sucesso!');
    }


    public function show($id)
    {
        $formulario = Formulario::find($id);
        $campos = CampoFormulario::where('formulario_id', $id)->get();
        return view('formularios', compact('formulario', 'campos'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search');

        // Realiza a busca pelos formulários cujo título corresponde ao termo de busca
        $formularios = Formulario::where('titulo', 'like', '%' . $search . '%')->first();

        if (!$formularios) {
            return response()->json(['message' => 'Nenhum formulário encontrado']);
        }

        $response = [
            'formularios' => [
                'titulo' => $formularios->titulo,
                'campos' => $formularios->campos->map(function($campo) use ($formularios){
                    $resposta = $formularios->respostas->firstwhere('campo_id', $campo->id);
                    return [
                        'titulo' => $campo->titulo,
                        'resposta' => $resposta ? $resposta->resp : null
                    ];
                })
            ]
        ];

        return response()->json($response);
    }
}
