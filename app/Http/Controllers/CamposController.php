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
        $formularios = Formulario::all();
        $camposFormularios = CampoFormulario::all();
        return view('formularios', compact('camposFormularios'));
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

        // Realiza a busca por campos pelo título
        $campos = CampoFormulario::where('titulo', 'like', '%' . $search . '%')->get();
        $formularios = Formulario::where('titulo', 'like', '%' . $search . '%')->get();
        $respostas = RespFormulario::where('resp', 'like', '%' . $search . '%')->get();

        $resultados = [
            'campos' => $campos,
            'formularios' => $formularios,
            'respostas' => $respostas
        ];

        return response()->json($resultados);
    }
}

// Para trazer dados de múltiplas tabelas e exibi-los no frontend utilizando JavaScript,
// você pode ajustar o método search no CamposController para incluir informações de várias tabelas e
// depois processar esses dados no JavaScript. Aqui está como você pode fazer isso:
