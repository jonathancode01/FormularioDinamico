<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CampoFormulario;
use App\Models\Formulario;
use App\Models\RespFormulario;

class CamposController extends Controller
{


    public function index(){

        $formularios = Formulario::all();
        $camposFormulario = CampoFormulario::all();

        return view('/formularios', compact('camposFormulario', 'formularios'));
    }

    public function store(Request $request)
    {
        $formularioId = $request->input('formulario_id'); // Assumindo que o ID do formulário é enviado no request

        foreach ($request->input('campos') as $campo) {
            $request->validate([
                'campos.*.resp' => 'required|string',
                'campos.*.tipo' => 'required|string|in:texto,textoarea',
            ]);

            RespFormulario::create([
                'resp' => $campo['resp'],
                'resp_tipo' => $campo['tipo'],
                'formulario_id' => $formularioId, // Assumindo que você quer relacionar a resposta com um formulário específico
            ]);
        }


        return redirect('formularios');
    }

    public function show($id)
    {
        $ordemTipos = [
            'texto' => 1,
            'textoarea' => 2,

        ];

        $formularios = Formulario::find($id);
        $campoFormulario = CampoFormulario::where('formulario_id', $id)->orderBy('id', 'asc')->get();
        $campoFormulario = $campoFormulario->sortBy(function($campo) use ($ordemTipos) {
            return $ordemTipos[$campo->tipo];
        });

        return view('formularios', compact('campoFormulario', 'formularios'));
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
